<?php

namespace Kotsis\Pushit;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class PushitServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    //protected $defer = true;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../views', 'kmak/pushit');

        //php artisan vendor:publish after installation of package...
        $this->publishes([
            __DIR__.'/../../config/pushit.php' => config_path('pushit.php'),
        ]);

        $this->publishes([
            __DIR__.'/../../assets' => public_path('vendor/kmak/pushit'),
        ], 'public');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Kotsis\Pushit\VapidInitCommand::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    //public function provides()
    //{
    //    return [Kotsis\Pushit\PushitController::class];
    //}
}

