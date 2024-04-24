<?php

namespace App\Events\Notification;

use App\Models\Notification\NotificationDataDto;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly string                   $type,
        public readonly int                      $userId,
        public readonly NotificationDataDto|null $data = null
    )
    {
        //
    }

}
