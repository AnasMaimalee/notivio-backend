<?php

namespace App\Providers;

use App\Models\Attachment;
use App\Policies\AttachmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Attachment::class => AttachmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // You can define extra Gates here later if needed
        // Gate::define('admin-only', fn ($user) => $user->role === 'superadmin');
    }
}
