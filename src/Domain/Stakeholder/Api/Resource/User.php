<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Api\Resource;

use ApiPlatform\Core\Annotation as Api;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Domain\Stakeholder\Api\Endpoint\RegisterAUser;

/**
 * @Api\ApiResource(
 *     collectionOperations={
 *         "post"={
 *             "controller"=RegisterAUser::class,
 *         },
 *     },
 *     itemOperations={
 *         "get"
 *     },
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}}
 * )
 */
final class User
{
    /**
     * @var string
     *
     * @Api\ApiProperty(identifier=true)
     *
     * @Groups({"user:read"})
     */
    private $userId;

    /**
     * @var string
     *
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @var string
     *
     * @Groups({"user:write"})
     */
    private $password;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }
}
