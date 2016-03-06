<?php
namespace Cloudoki\OaStack\Seeds;

use Cloudoki\OaStack\Models\User;
use Cloudoki\OaStack\Models\Oauth2Client;
use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder 
{
    public function run()
    {
        $client = new Oauth2Client ();
		$client ->setClientId ()
				->setClientSecret ()
				->setName ('Project app')
				->setRedirectUri ('http://localhost/projectapp/auth.html');
		
		User::first()->oauth2clients()->save ($client);
    }
}