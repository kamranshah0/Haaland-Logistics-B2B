<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SystemNotification extends Notification
{
    use Queueable;

    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->details['title'] ?? 'New Notification',
            'message' => $this->details['message'] ?? '',
            'type' => $this->details['type'] ?? 'info',
            'link' => $this->details['link'] ?? '#',
            'icon' => $this->details['icon'] ?? 'bell',
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->details['title'] ?? 'New Notification',
            'message' => $this->details['message'] ?? '',
            'type' => $this->details['type'] ?? 'info',
            'link' => $this->details['link'] ?? '#',
            'icon' => $this->details['icon'] ?? 'bell',
            'created_at' => now()->diffForHumans(),
        ]);
    }
}
