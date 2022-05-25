<?php

namespace Tingo\LaravelTranslatable;

use Illuminate\Support\ServiceProvider;

class LaravelTranslatableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-translatable.php', 'laravel-translatable');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {

            // publish config file.
            $this->publishes([
                __DIR__ . '/../config/laravel-translatable.php' => config_path('laravel-translatable.php'),
            ], 'config');

            // Publish migrations
            $this->publishes([
                __DIR__ . '/../database/migrations/2022_05_24_154339_create_translations_table.php' => database_path('migrations/2022_05_24_154339_create_translations_table.php')
            ], 'migrations');
        }
    }
}