<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Підтвердити адресу електронної пошти')
                ->line('Натисніть кнопку нижче, щоб підтвердити свою електронну адресу')
                ->action('Підтвердити адресу електронної пошти', $url)

                ->salutation('З найкращими побажаннями, B-Day')
                ->greeting('Добрий день.')
                ->action('Підтвердити адресу електронної пошти', $url);
        });
    }
}
