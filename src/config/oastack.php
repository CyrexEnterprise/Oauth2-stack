<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Oauth2-Stack uri's
	|--------------------------------------------------------------------------
	|
	| The Oauth2-Stack uri's are being used in both pageviews as e-mails.
	| You might want to edit this config in your .app/config/vendor environment.
	|
	*/
	'invite_url' => env('OASTACK_INVITE_URL', 'http://localhost/oauth2/invitation'),
	'reset_url' =>  env('OASTACK_RESET_URL', 'http://localhost/oauth2/reset'),
	'privacy_url' => env('OASTACK_PRIVACY_URL', 'http://en.wikipedia.org/wiki/Privacy_policy'),
	// Optional. A job dispatcher class with a static `dispatch` method.
	'job_dispatcher' =>  env('OASTACK_JOB_DISPATCHER', null),
	// Optional. The `user` model of the base application.
	// The user model must use the provided Traits\User trait.
	'user_model' =>  env('OASTACK_USER_MODEL', null),
    /*
	 * The URL to which users should be redirected after resetting their password
	 */
    'redirect_url' => '',
);
