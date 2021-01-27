<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Command\Message;

final class RegisterAUser
{
    private $userId;
    private $email;
    private $password;

    public function __construct(string $email, string $password, ?string $userId)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
