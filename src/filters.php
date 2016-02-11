<?php

/*
|--------------------------------------------------------------------------
| API-side Authentication Filter
|--------------------------------------------------------------------------
|
| The following filter is used to simply verify that the user has an authentication token.
| You may want to include or copy the filter to your general ./app/filters.php file.
*/

Route::filter ('auth', function()
{
	# Default bearer
	$bearer = Request::header ('Authorization');
	
	
	# Get based bearer, debug only
	if(!$bearer && Config::get ('app.debug'))
	
		$bearer = Input::get('bearer');
	
	if(!$bearer || strlen ($bearer) < 18)
	
		throw new \InvalidUserException ('no valid authorization provided');
	

	# Add Access token to input
	$bearer = explode(' ', $bearer);
	
	Input::merge (array('access_token'=> array_pop ($bearer)));
});