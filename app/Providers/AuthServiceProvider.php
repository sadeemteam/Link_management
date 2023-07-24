<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class AuthServiceProvider extends ServiceProvider
{
    protected function verificationUrl($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        return str_replace(url('/api'), env('APP_URL') . '/api', $url);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
        
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            $app = AppSetting::first();

            return (new MailMessage)
                ->markdown('auth.verify-email', [
                    'app' => $app,
                    'url' => $this->verificationUrl($notifiable)
                ]);
        });
    }
}
