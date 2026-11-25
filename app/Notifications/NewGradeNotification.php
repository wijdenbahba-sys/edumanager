<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewGradeNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database']; // N7ottouha fil base de données
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => '/my-profile', // Fin bech yemchi ki y9os 3al notification
        ];
    }
}