<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationAccepted extends Notification
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
            'message' => 'Your application for the job titled ' .'<a href="'.route('posting.application',$this->application->posting->id) . '">' . $this->application->posting->title .'</a>'. ' has been accepted.',
            'type' => 'application_acceptance',
            'post_id' => $this->application->posting->id,
        ];
    }
}
