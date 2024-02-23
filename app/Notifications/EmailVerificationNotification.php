<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class EmailVerificationNotification extends VerifyEmail
{
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $prefix          = 'https://bday.intita.com/verify-email?url=';
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Підтвердити адресу електронної пошти')
            ->line('Натисніть кнопку нижче, щоб підтвердити свою електронну адресу')
            ->action('Підтвердити адресу електронної пошти', $prefix . urlencode($verificationUrl))
            ->salutation('З найкращими побажаннями, B-Day')
            ->greeting('Добрий день.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}