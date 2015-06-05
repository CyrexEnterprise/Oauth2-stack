<?php
	
use Illuminate\Database\Seeder;

class OaStackSeeder extends Seeder {

    public function run()
    {
        $this->call('AccountTableSeeder');
        $this->call('UserTableSeeder');

        $this->command->info('User table seeded!');
    }

}

class AccountTableSeeder extends Seeder {

    public function run()
    {
       User::create(['name' => 'Project Account']);
    }

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        User::create(['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']);
    }

}