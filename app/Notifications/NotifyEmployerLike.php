<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use function PHPSTORM_META\type;

class NotifyEmployerLike extends Notification
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
            'message' => 'Your post "' . $this->posting->title . '" was liked.',
            'post_id' => $this->posting->id,
            'type' => 'like',
        ];
    }
}
