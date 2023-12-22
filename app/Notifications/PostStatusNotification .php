<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostStatusNotification  extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $worker,$post;
    public function __construct($worker,$post)
    {
        $this->worker=$worker;
        $this->post=$post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'worker'=>$this->worker,
            'post'=>$this->post,
        ];
    }
}
