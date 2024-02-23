<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserInvitationCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $adminName, private string $roleName)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('messages.invitation.mail.subject', ['service' => config('app.name')]))
            ->line(
                __('messages.invitation.mail.content', [
                    'admin_name' => $this->adminName,
                    'service' => config('app.name'),
                    'user_role' => $this->roleName
                ])
            )
            ->action(__('messages.invitation.mail.action'), route('users.invitation.verify', $notifiable->signature));
    }
}
