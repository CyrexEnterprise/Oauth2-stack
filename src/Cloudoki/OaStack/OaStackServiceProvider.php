<?php

namespace Cloudoki\OaStack;

use Illuminate\Support\ServiceProvider;

class OaStackServiceProvider extends ServiceProvider
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

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('cloudoki.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../../views', 'oastack');

        # Oauth2 Routes
        include __DIR__.'/../../routes.php';

        # Ouath2 simple filter
        include __DIR__.'/../../filters.php';

        $this->publishes([
            __DIR__.'/../../migrations/' => database_path('migrations')
        ], 'migrations');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app['oastack'] = $this->app->share(function ($app) {
            return new OaStack;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('oastack');
    }

}
