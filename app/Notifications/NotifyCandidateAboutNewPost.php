<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use function PHPSTORM_META\type;

class NotifyCandidateAboutNewPost extends Notification
{
    use Queueable;

    protected $post;
    protected $candidate;

    public function __construct($post,$candidate)
    {
        $this->post = $post;
        $this->candidate = $candidate;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new job posting "' . $this->post->title . '" has been made public.',
            'post_id' => $this->post->id,
            'candidate_id' => $this->candidate->id,
            'type' => 'new_post',
        ];
    }
}
