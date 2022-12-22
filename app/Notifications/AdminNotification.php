<?php

namespace App\Notifications;

use App\Mail\NotificationMailable;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    public function __construct(
        private string $title,
        private string $content,
        private int $senderID,
    ) {
        //
    }

    public function getSenderID()
    {
        return $this->senderID;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->isNotificationEnabled('email_system_notification')) {
            return ['mail', 'database'];
        }
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NotificationMailable
     */
    public function toMail($notifiable)
    {
        return (new NotificationMailable(
                $notifiable,
                $this->title,
                $this->content,
                User::find($this->getSenderID())
            ))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}
