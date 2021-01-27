<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Api\Endpoint;

use App\Domain\Stakeholder\Api\Resource\User;
use App\Domain\Stakeholder\Command\Message\RegisterAUser as RegisterAUserMessage;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;

final class RegisterAUser extends AbstractController
{
    public function __invoke(User $data, MessageBusInterface $bus)
    {
        $userId = (string) Uuid::uuid4();

        $bus->dispatch(new RegisterAUserMessage(
            $data->getEmail(),
            $data->getPassword(),
            $userId
        ));

        $location = $this->generateUrl('api_users_get_item', ['id' => $userId]);

        return new JsonResponse(null, JsonResponse::HTTP_CREATED, ['Location' => $location]);
    }
}
