<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\CompagnyVerifications;
use App\Models\Job;
use App\Policies\ApplicationPolicy;
use App\Policies\CompagnyVerificationsPolicy;
use App\Policies\JobPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Job::class => JobPolicy::class,
        Application::class => ApplicationPolicy::class,
        CompagnyVerifications::class => CompagnyVerificationsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        //
    }
}
