<?php

namespace App\Providers;

use App\Models\Centro;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Programa;
use App\Policies\CentroPolicy;
use App\Policies\UserPolicy;
use App\Policies\InstructoresPolicy;
use App\Policies\ProgramaPolicy;
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
        Centro::class => CentroPolicy::class,
        User::class => UserPolicy::class,
        Instructor::class => InstructoresPolicy::class,
        Programa::class => ProgramaPolicy::class,
        


    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Solo permitir que cada usuario edite o elimine su propio perfil
        Gate::define('profile.update', function (User $user, User $target) {
            return $user->id === $target->id;
        });

        Gate::define('profile.delete', function (User $user, User $target) {
            return $user->id === $target->id;
        });
    }
}