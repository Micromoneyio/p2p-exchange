<?php

namespace App\Observers;

use App\Events\SendNotification;
use App\Notification;

class NotificationObserver
{
    /**
     * Handle to the notification "created" event.
     *
     * @param  \App\Notification  $notification
     * @return void
     */
    public function created(Notification $notification)
    {
        broadcast(new SendNotification($notification));
    }

    /**
     * Handle the notification "updated" event.
     *
     * @param  \App\Notification  $notification
     * @return void
     */
    public function updated(Notification $notification)
    {
        //
    }

    /**
     * Handle the notification "deleted" event.
     *
     * @param  \App\Notification  $notification
     * @return void
     */
    public function deleted(Notification $notification)
    {
        //
    }
}
