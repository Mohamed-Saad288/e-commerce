<?php

namespace App\Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(app_path('Modules/Admin/Database/Migrations'));

        $this->loadRoutesFrom(app_path('Modules/Admin/Routes/api.php'));
        $this->loadRoutesFrom(app_path('Modules/Admin/Routes/web.php'));
        $this->loadViewsFrom(app_path('Modules/Admin/Resources/views'), 'admin');
        foreach (glob(app_path('Modules/Admin/Helpers') . '/*.php') as $filename) {
            require_once $filename;
        }

        // Register middleware
//        $this->app['router']->aliasMiddleware('baseAuthMiddleware', \App\Modules\Admin\Http\Middleware\AdminAuthMiddleware::class);
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
