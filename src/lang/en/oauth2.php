<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Oauth2 Resources Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the /oauth2 views.
	|
	*/
	
	'user' =>
	[
		'login' =>
		[
			'title'		=> 'Log in',
			'info'		=> 'Please enter your credentials.',
			'email'		=> 'E-mail address',
			'password'	=> 'Password',
			'submit'	=> 'Log In',
			'retry'		=> 'Try again',
			'forgot'	=> 'Forgot password?'
		],
		
		'forgot' =>
		[
			'title'		=> 'Forgot Password',
			'info'		=> 'Please enter your e-mail address, we will send a reset link.',
			'email'		=> 'E-mail address',
			'submit'	=> 'Send reset link',
			'retry'		=> 'Try again',
			'back'		=> 'Go back',
		],
		
		'approve' =>
		[
			'title'		=> 'Authorize :name',
			'info'		=> 'Is :name allowed to access your information?',
			'allow'		=> 'Approve',
			'deny'		=> 'Deny',
			'footer'	=> 'You are logged in as :fullname.'
		],
		
		'reset' =>
		[
			'title'		=> 'Reset Password',
			'info'		=> 'Please enter your corresponding e-mail address and your new password (twice).',
			'email'		=> 'E-mail address',
			'password'	=> 'New Password &nbsp; &nbsp;',
			'password_conf'	=> 'Repeat Password',
			'minchars'	=> 'min. 6 chars',
			'submit'	=> 'Change'
		],
		
		'invite' =>
		[
			'title'		=> 'Invite User',
			'info'		=> 'Provide the user\'s e-mail address, first and last name. An invitation e-mail will be sent for the selected account.',
			'firstname'	=> 'First Name',
			'fholder'	=> 'John',
			'lastname'	=> 'Last Name',
			'lholder'	=> 'Doe',
			'email'		=> 'E-mail address',
			'eholder'	=> 'johndoe@gmail.com',
			'account'	=> 'Account',
			'submit'	=> 'Send Invite'
		],
		
		'subscribe' =>
		[
			'subject'	=> 'User Registration',
			'title'		=> 'Subscribe to the :account Invitation',
			'info'		=> 'Please confirm your basic information, it will only be used internally by :account',
			'firstname'	=> 'First Name',
			'fholder'	=> 'John',
			'lastname'	=> 'Last Name',
			'lholder'	=> 'Doe',
			'email'		=> 'E-mail address',
			'eholder'	=> 'johndoe@gmail.com',
			'password'	=> 'Password &nbsp; &nbsp; &nbsp; &nbsp;',
			'minchars'	=> 'min. 6 chars',
			'password_conf'	=> 'Repeat Password',
			'submit'	=> 'Register',
			'footer'	=> 'You can find out more about our privacy policy at '
		],
		
		'subscribed' =>
		[
			'title'	=> ':appname Registration',
			'info'		=> 'Your subscription to :account was successful!',
			'retry'		=> 'Retry subscription',
			'proceed'	=> 'Proceed'
		]
	],
	
	'app' =>
	[
		'register' =>
		[
			'title'			=> 'Register Oauth2 enabled App',
			'info'			=> 'Please provide a valid redirect URI. This application ID must be equal to the redirect URI used in your authorization call.',
			'app'			=> 'App name:',
			'redirect'		=> 'Redirect URI:',
			'submit'		=> 'Register OAuth2 app'
		],
		
		'registered' =>
		[
			'title'			=> 'OAuth2 app registered',
			'info'			=> 'Please use following Client ID in your OAuth2 application.',
			'client_id'		=> 'OAuth2 Client ID:',
			'client_secret'	=> 'OAuth2 Client Secret:',
			'redirect_uri'	=> 'Redirect URI:',
			'retry'			=> 'Retry registration',
			'more'			=> 'One More'
		]
	]
	
);
