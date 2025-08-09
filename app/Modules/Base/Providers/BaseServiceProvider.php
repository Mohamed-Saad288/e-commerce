<?php

namespace App\Modules\Base\Providers;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(app_path('Modules/Base/Database/Migrations'));

        $this->loadRoutesFrom(app_path('Modules/Base/Routes/api.php'));
        $this->loadRoutesFrom(app_path('Modules/Base/Routes/web.php'));
        $this->loadViewsFrom(app_path('Modules/Base/Resources/views'), 'base');
        foreach (glob(app_path('Modules/Base/Helpers') . '/*.php') as $filename) {
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
