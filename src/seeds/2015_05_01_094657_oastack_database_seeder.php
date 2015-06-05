<?php
	
use Illuminate\Database\Seeder;

class OaStackSeeder extends Seeder {

    public function run()
    {
        $this->call('OaAccountTableSeeder');
        $this->call('OaUserTableSeeder');

        $this->command->info('User table seeded!');
    }

}

class OaAccountTableSeeder extends Seeder {

    public function run()
    {
       Account::create(['name' => 'Project Account']);
    }

}

class OaUserTableSeeder extends Seeder {

    public function run()
    {
        User::create(['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']);
    }

}