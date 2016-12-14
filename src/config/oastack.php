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

	'invite_url' => 'http://localhost/oauth2/invitation',
	'reset_url' =>  'http://localhost/oauth2/reset',
	'privacy_url' => 'http://en.wikipedia.org/wiki/Privacy_policy',
	// Optional. A job dispatcher class with a static `dispatch` method.
	'jobDispatcher' =>  null,
	// Optional. The `user` model of the base application.
	// The user model must use the provided Traits\User trait.
	'userModel' =>  null,
);
