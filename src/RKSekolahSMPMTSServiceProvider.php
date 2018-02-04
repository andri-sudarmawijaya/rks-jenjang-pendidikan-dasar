<?php

namespace Bantenprov\RKSJePenDas;

use Illuminate\Support\ServiceProvider;
use Bantenprov\RKSJePenDas\Console\Commands\RKSJePenDasCommand;

/**
 * The RKSJePenDasServiceProvider class
 *
 * @package Bantenprov\RKSJePenDas
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class RKSJePenDasServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap handles
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rks-jen-pen-das', function ($app) {
            return new RKSJePenDas;
        });

        $this->app->singleton('command.rks-jen-pen-das', function ($app) {
            return new RKSJePenDasCommand;
        });

        $this->commands('command.rks-jen-pen-das');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'rks-jen-pen-das',
            'command.rks-jen-pen-das',
        ];
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('rks-jen-pen-das.php');

        $this->mergeConfigFrom($packageConfigPath, 'rks-jen-pen-das');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'config');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'rks-jen-pen-das');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/rks-jen-pen-das'),
        ], 'lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'rks-jen-pen-das');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/rks-jen-pen-das'),
        ], 'views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'rks-jen-pen-das-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'rks-jen-pen-das-public');
    }
}
