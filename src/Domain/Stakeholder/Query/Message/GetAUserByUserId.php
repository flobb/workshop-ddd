<?php

declare(strict_types=1);

namespace App\Domain\Stakeholder\Query\Message;

final class GetAUserByUserId
{
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
