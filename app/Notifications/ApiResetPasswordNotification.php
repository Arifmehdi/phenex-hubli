<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApiResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public static $createUrlCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $email = $notifiable->getEmailForPasswordReset();

        if (static::$createUrlCallback) {
            $resetUrl = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } elseif (config('app.frontend_url')) {
            // Optional: separate SPA / mobile frontend handles the reset screen
            $resetUrl = rtrim(config('app.frontend_url'), '/') . '/reset-password?token=' . $this->token . '&email=' . urlencode($email);
        } else {
            // Default: this application's own web reset page. The URL is
            // generated from the current request's host, so it follows
            // whatever domain the application is served from.
            $resetUrl = route('password.reset', [
                'token' => $this->token,
                'email' => $email,
            ]);
        }

        return (new MailMessage)
                    ->subject('Reset Password Notification')
                    ->line('You are receiving this email because we received a password reset request for your account.')
                    ->action('Reset Password', $resetUrl)
                    ->line('This password reset link will expire in ' . config('auth.passwords.users.expire') . ' minutes.')
                    ->line('If you did not request a password reset, no further action is required.')
                    ->line('Alternatively, you can use the following token and email in your application to reset your password:')
                    ->line('Token: ' . $this->token)
                    ->line('Email: ' . $email);
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
            //
        ];
    }
}
