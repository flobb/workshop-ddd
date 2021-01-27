<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Command\Handler;

use App\Domain\Stakeholder\Command\Message\RegisterAUser;
use App\Domain\Stakeholder\Model\User;
use App\Infrastructure\Domain\DomainObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RegisterAUserHandler implements MessageHandlerInterface
{
    private $domainObjectManager;

    public function __construct(DomainObjectManager $domainObjectManager)
    {
        $this->domainObjectManager = $domainObjectManager;
    }

    public function __invoke(RegisterAUser $message)
    {
        $user = new User();
        $user->setUserId($message->getUserId() ?? (string) Uuid::uuid4());
        $user->setEmail($message->getEmail());
        $user->setPassword($message->getPassword());

        $this->domainObjectManager->persist($user);

        return $user;
    }
}
