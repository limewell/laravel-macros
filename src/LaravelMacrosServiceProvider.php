<?php

namespace Limewell\LaravelMacros;

use Illuminate\Support\ServiceProvider;

class LaravelMacrosServiceProvider extends ServiceProvider
{
    private function getIncludes($dir, array &$files = []): array
    {
        if (is_dir($dir)) {
            foreach (scandir($dir) as $inode) {
                $path = realpath($dir . DIRECTORY_SEPARATOR . $inode);
                if (!is_dir($path)) {
                    !(pathinfo($path, PATHINFO_EXTENSION) === "php") ?: array_push($files, $path);
                } elseif (!in_array($inode, [".", ".."])) {
                    self::getIncludes($path, $files);
                }
            }
        }
        return $files;
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * include macros
         * */
        array_map(function ($helper) {
            require_once($helper);
        }, self::getIncludes(__DIR__.'/../Macros'));

        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-macros');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-macros');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-macros.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-macros'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-macros'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-macros'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-macros');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-macros', function () {
            return new LaravelMacros;
        });
    }
}
