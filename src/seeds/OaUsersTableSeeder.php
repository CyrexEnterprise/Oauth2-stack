<?php
namespace Cloudoki\OaStack\Seeds;

use Cloudoki\OaStack\Models\User;
use Cloudoki\OaStack\Models\Account;
use Illuminate\Database\Seeder;

class OaUsersTableSeeder extends Seeder 
{
    public function run()
    {
		$user = new User (['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']); //User::create(['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']);
		
		Account::first()
			->users()
			->save ($user);
    }
}