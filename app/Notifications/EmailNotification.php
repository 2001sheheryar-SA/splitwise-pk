<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class EmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private string $token;
    private string $expires;
    private int $invite;

    public function __construct(string $token,string $expires, int $invite)
    {
        $this->token = $token;
        $this->expires = $expires;
        $this->invite = $invite;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $queryParams = http_build_query([
            'token' => $this->token,
            'expires' => $this->expires,
            'invite' => $this->invite,
        ]);
       
        $url = url('verify-email'). '?' . $queryParams;
        
        return (new MailMessage)
            ->from('chatapp@example.com', 'Laravel Chat App')
            ->subject('Company Notification')
            ->line('The introduction to the notification.')
            ->action('Notification Action',$url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
