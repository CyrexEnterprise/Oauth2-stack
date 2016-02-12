<?php
	
use Illuminate\Database\Seeder;

class OaStackSeeder extends Seeder {

    public function run()
    {
        $this->call('OaAccountsTableSeeder');
        $this->call('OaUsersTableSeeder');
        $this->call('OauthClientsTableSeeder');

        $this->command->info('OaStack tables seeded!');
    }

}

class OaAccountsTableSeeder extends Seeder {

    public function run()
    {
       Account::create(['name' => 'Project Account']);
    }

}

class OaUsersTableSeeder extends Seeder {

    public function run()
    {
        User::create(['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']);
    }

}

class OauthClientsTableSeeder extends Seeder {

    public function run()
    {
        $client = new Oauth2Client ();
		$client ->setUser (1)
				->setClientId ()
				->setClientSecret ()
				->setName ('Project app')
				->setRedirectUri ('http://localhost/projectapp/auth.html')
				->save ();
    }

}