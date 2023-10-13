<?php

namespace LaravelLiberu\Roles;

use Illuminate\Support\ServiceProvider;
use LaravelLiberu\Roles\Commands\Sync;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load()
            ->publish()
            ->commands(Sync::class);
    }

    private function load()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/roles.php', 'liberu.roles');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        return $this;
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/../config' => config_path('liberu'),
        ], ['roles-config', 'liberu-config']);

        $this->publishes([
            __DIR__.'/../database/factories' => database_path('factories'),
        ], ['roles-factory', 'liberu-factories']);

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], ['roles-seeder', 'liberu-seeders']);

        return $this;
    }
}
