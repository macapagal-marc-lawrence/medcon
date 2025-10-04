<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Services\MailService;

class CustomResetPasswordNotification extends Notification
{
    private $token;
    private $mailService;

    public function __construct($token)
    {
        $this->token = $token;
        $this->mailService = app(MailService::class);
    }

    public function via($notifiable)
    {
        return ['custom'];
    }

    public function send($notifiable)
    {
        return $this->mailService->sendPasswordResetEmail($notifiable, $this->token);
    }
}
