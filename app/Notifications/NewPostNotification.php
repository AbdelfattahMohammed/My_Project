<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'A new post has been created: ' . $this->post->title,
            'post_id' => $this->post->id,
            'type' => 'create_post',
        ];
    }
}

