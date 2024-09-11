<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationSended extends Notification
{
    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    // Define how to send the notification
    public function via($notifiable)
    {
        return ['database']; // Store the notification in the database
    }

    // Customize the notification content
    public function toArray($notifiable)
    {
        return [
            'application_id' => $this->application->id,
            'message' =>' New application has been added.',
            'type' => 'application_sended',

        ];
    }
}
