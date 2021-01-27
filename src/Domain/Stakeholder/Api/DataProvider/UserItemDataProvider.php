<?php
// api/src/DataProvider/BlogPostItemDataProvider.php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Api\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Domain\Stakeholder\Api\Resource\User;
use App\Domain\Stakeholder\Query\Message\GetAUserByUserId;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use App\Domain\Stakeholder\Model\User as UserModel;

final class UserItemDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?User
    {
        $envelope = $this->bus->dispatch(new GetAUserByUserId($id));
        $handledStamp = $envelope->last(HandledStamp::class);

        if (null === $handledStamp) {
            throw new \RuntimeException('This dispatcher need to be sync');
        }

        /** @var UserModel $data */
        $data = $handledStamp->getResult();

        if (!$data instanceof UserModel) {
            return null;
        }

        $user = new User();
        $user->setUserId($data->getUserId());
        $user->setEmail($data->getEmail());

        return $user;
    }
}
