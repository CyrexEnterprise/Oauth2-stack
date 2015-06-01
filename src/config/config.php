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
	'privacyurl' => 'http://en.wikipedia.org/wiki/Privacy_policy',
	
	'timezone' => 'Europe/Brussels',
	
	/*
	|--------------------------------------------------------------------------
	| Oauth2-Stack models schema location
	|--------------------------------------------------------------------------
	|
	| The Oauth2-Stack models use schema json files to define the output.
	|
	*/ 
	
	'schemas' => array
	(
		'path'=> __DIR__ . '/../schemas/',
		
		'seeds' => array
		(
			'path'=> __DIR__ . '/../schemas/seeds/'
		)
	)

);
