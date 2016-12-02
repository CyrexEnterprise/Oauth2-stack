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
		# Oauth2 Routes
		if (! $this->app->routesAreCached ())
		{
			require __DIR__.'/../../routes.php';
		}

		# Oauth2 Views
		$this->loadViewsFrom (__DIR__.'/Views', 'oastack');

		$this->publishes (
		[
			__DIR__.'/Views' => base_path ('resources/views/vendor/oastack'),
		]);

		# Oauth2 i18n
		$this->loadTranslationsFrom (__DIR__.'/../../lang', 'oastack');

		$this->publishes (
		[
			__DIR__.'/../../lang' => base_path ('resources/lang/vendor/oastack')
		], 'lang');

		# Oauth2 config
		$this->publishes (
		[
			__DIR__.'/../../config/oastack.php' => config_path ('oastack.php')
		], 'config');

		#Oauth2 Migrations
		$this->publishes(
		[
			__DIR__.'/../../migrations/' => database_path ('migrations')
		], 'migrations');
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
		return ['oastack'];
	}

}