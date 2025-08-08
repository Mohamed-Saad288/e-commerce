<?php

namespace App\Modules\Organization\Providers;

use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(app_path('Modules/Organization/Database/Migrations'));

        $this->loadRoutesFrom(app_path('Modules/Organization/Routes/api.php'));
        $this->loadRoutesFrom(app_path('Modules/Organization/Routes/web.php'));
        foreach (glob(app_path('Modules/Organization/Helpers') . '/*.php') as $filename) {
            require_once $filename;
        }

        // Register middleware
//        $this->app['router']->aliasMiddleware('baseAuthMiddleware', \App\Modules\Base\Http\Middleware\BaseAuthMiddleware::class);
        // config([
        //     'auth.guards.user' => [
        //         'driver' => 'sanctum',
        //         'provider' => 'employees',
        //     ],
        //     'auth.providers.employees' => [
        //         'driver' => 'eloquent',
        //         'model' => User::class,
        //     ],
        // ]);
    }
}
