<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostNotifications extends Notification
{
    use Queueable;

    protected $worker, $post;
    public function __construct($worker, $post)
    {
        $this->worker = $worker;
        $this->post = $post;
    }


    public function via(object $notifiable): array
    {
        return ['database'];
    }



    public function toArray(object $notifiable): array
    {
        return [
            'worker' => $this->worker,
            'post' => $this->post,
        ];
    }
}
