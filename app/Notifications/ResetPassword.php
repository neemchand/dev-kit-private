<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPasswordNotification;

class ResetPassword extends BaseResetPasswordNotification
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage())
            ->subject(__('auth.password_reset_mail.subject'))
            ->line(__('auth.password_reset_mail.line1'))
            ->action(__('auth.reset_password'), $url)
            ->line(__('auth.password_reset_mail.line2'));
    }
}
