<?php

namespace App\Providers;

use App\Console\Commands\CustomMakeFactory;
use Illuminate\Support\ServiceProvider;

/**
 * CustomMakeFactoryServiceProvider.
 */
class CustomMakeFactoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->app->singleton('command.factory.make', function ($app) {
            return new CustomMakeFactory($app['files']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
