<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use function PHPSTORM_META\type;

class NotifyEmployerAboutAcceptance extends Notification
{
    use Queueable;

    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    // Specify that we want to use the 'database' channel
    public function via($notifiable)
    {
        return ['database'];
    }

    // Define the data that will be stored in the database
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your job posting "' . $this->post->title . '" has been accepted.',
            'post_id' => $this->post->id,
            'type' => 'job_acceptance',
        ];
    }
}
