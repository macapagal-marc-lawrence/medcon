<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;

class CustomChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        return $notification->send($notifiable);
    }
}
