<?php

namespace App\Listeners\Notification;


use App\Actions\Notification\CreateNewNotificationAction;
use App\Events\Notification\NewNotificationEvent;

class NewNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewNotificationEvent $event): void
    {
        (new CreateNewNotificationAction)->execute($event->type, $event->userId, $event->data);

    }
}
