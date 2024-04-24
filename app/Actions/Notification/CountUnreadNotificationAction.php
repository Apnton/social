<?php

namespace App\Actions\Notification;

use App\Models\Notification\Notification;

class CountUnreadNotificationAction
{
    public function execute(): int
    {
       return auth()->user()->notifications()->whereNull('read_at')->count();
    }

}
