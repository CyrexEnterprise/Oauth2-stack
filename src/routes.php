<?php

/*
|--------------------------------------------------------------------------
| Oauth2 Routes
|--------------------------------------------------------------------------
|
| All the Oauth2 Endpoints are defined here.
| You may want to include or copy them to your general ./app/routes.php file.
|
*/

Route::group(array ('prefix'=> 'oauth2'), function ()
{
	# User
	Route::get ('login', ['as' => 'login', 'uses'=> 'OaStackViewController@login']);
	Route::post ('login', ['before'=> 'csrf', 'uses'=> 'OaStackViewController@loginrequest']);
	
	Route::get ('forgot', 'OaStackViewController@forgot');
	Route::post ('forgot', ['before'=> 'csrf', 'uses'=> 'OaStackViewController@resetrequest']);
	Route::get ('reset/{reset_token}', 'OaStackViewController@reset');
	Route::post ('reset/{reset_token}', 'OaStackViewController@changepassword');
	
	Route::post ('authorize', ['before'=> 'csrf', 'uses'=> 'OaStackViewController@approve']);
	
	Route::get ('invitation/{path?}', 'OaStackViewController@subscribe');
	Route::post ('invitation/{path?}', 'OaStackViewController@subscribed');
});

# Authentication required.

Route::group(array ('prefix'=> 'oauth2', 'before'=> 'auth'), function ()
{
	# App
	Route::get ('register', 'OaStackViewController@registerapp');
	Route::post ('register', 'OaStackViewController@registeredapp');
});