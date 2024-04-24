<?php

namespace App\Actions\Notification;

use App\Models\Notification\Notification;
use App\Models\Notification\NotificationDataDto;

class CreateNewNotificationAction
{
    public function execute(string $type, int $userId, NotificationDataDto|null $data): void
    {
        Notification::create([
            'type' => $type,
            'user_id' => $userId,
            'data' => $data->getNotNullArray()
        ]);
    }

}
