<?php
namespace Cloudoki\OaStack;

use Illuminate\Support\ServiceProvider;

class OaStackServiceProvider extends ServiceProvider {

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
		# $this->package('cloudoki/oastack');
		
		# Oauth2 Routes
		if (! $this->app->routesAreCached ())
		{
			require __DIR__.'/../../routes.php';
		}
		
		# Oauth2 Views
		$this->loadViewsFrom (__DIR__.'/Views', 'oastack');
		
		$this->publishes (
		[
			__DIR__.'/../../views' => resource_path ('views/vendor/oastack'),
		]);
		
		# Oauth2 i18n
		$this->loadTranslationsFrom (__DIR__.'/../../lang', 'oastack');
		
		$this->publishes (
		[
			__DIR__.'/../../lang' => resource_path ('lang/vendor/oastack'),
		]);
		
		#Oauth2 Migrations
		$this->publishes(
		[
			__DIR__.'/../../migrations/' => database_path ('migrations')
		], 'migrations');
		
		# Ouath2 simple filter
		# include __DIR__.'/../../filters.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['oastack'] = $this->app->share(function($app)
        {
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
