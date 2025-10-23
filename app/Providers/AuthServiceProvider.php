<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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
        $this->registerPolicies();

        // Gates Individuales
        Gate::define('esAdministrador', function (User $user) {
            return $user->role == 'administrador';
        });

        Gate::define('esSupervisor', function (User $user) {
            return $user->role == 'supervisor';
        });

        // Gates Combinados
        Gate::define('esAdministradorOsupervisor', function (User $user) {
            return $user->role == 'administrador' || $user->role == 'supervisor';
        });
    }
}
