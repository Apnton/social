<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        VerifyEmail::createUrlUsing(function ($notifiable) {

            $frontendUrl = \config('app.url_frontend');

            return $frontendUrl
                . '?id=' . $notifiable->getKey()
                . '&hash=' . sha1($notifiable->getEmailForVerification());
        });
    }
}
