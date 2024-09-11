<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use function PHPSTORM_META\type;

class NotifyEmployerShare extends Notification
{
    use Queueable;

    protected $posting;

    public function __construct($posting)
    {
        $this->posting = $posting;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your post "' . $this->posting->title . '" has been shared.',
            'post_id' => $this->posting->id,
            'type' => 'share',
        ];
    }
}
