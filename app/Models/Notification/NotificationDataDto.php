<?php

namespace App\Models\Notification;

class NotificationDataDto
{
    public function __construct(
        private readonly ?int    $userId = null,
        private readonly ?string $userName = null,
    )
    {
    }

    public function getAll(): array
    {
        return [
            'userId' => $this->userId,
            'name' => $this->userName,
        ];
    }

    public function getNotNullArray(): array
    {
        return array_filter($this->getAll(), fn($item) => $item !== null);
    }
}
