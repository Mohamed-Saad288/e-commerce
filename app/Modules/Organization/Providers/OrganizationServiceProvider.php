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
        // load migrations
        $this->loadMigrationsFrom(app_path('Modules/Organization/Database/Migrations'));

        // load routes
        $this->loadRoutesFrom(app_path('Modules/Organization/Routes/api.php'));
        $this->loadRoutesFrom(app_path('Modules/Organization/Routes/web.php'));

        // load views
        $this->loadViewsFrom(app_path('Modules/Organization/Resources/views'), 'organization');

        // load helpers
        foreach (glob(app_path('Modules/Organization/Helpers') . '/*.php') as $filename) {
            require_once $filename;
        }

        // load all config files
        $configPath = app_path('Modules/Organization/Config');
        foreach (glob($configPath.'/*.php') as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME); // اسم الملف بدون .php
            $this->mergeConfigFrom($file, "organization.$name");
        }
    }

}
