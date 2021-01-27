<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Query\Handler;

use App\Domain\Stakeholder\Model\User;
use App\Infrastructure\Domain\DomainObjectManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Domain\Stakeholder\Query\Message\GetAUserByUserId as GetAUserByUserIdMessage;

final class GetAUserByUserId implements MessageHandlerInterface
{
    private $domainObjectManager;

    public function __construct(DomainObjectManager $domainObjectManager)
    {
        $this->domainObjectManager = $domainObjectManager;
    }

    public function __invoke(GetAUserByUserIdMessage $message)
    {
        $repository = $this->domainObjectManager->getRepositoryForClass(User::class);

        return $repository->findOneBy(['userId' => $message->getUserId()]);
    }
}
