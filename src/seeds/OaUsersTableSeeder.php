<?php
namespace Cloudoki\OaStack\Seeds;

use Cloudoki\OaStack\Models\User;
use Cloudoki\OaStack\Models\Account;
use Illuminate\Database\Seeder;

class OaUsersTableSeeder extends Seeder 
{
    public function run()
    {
		$user = new User (['email' => 'zen@cloudoki.com', 'firstname'=> 'Zen', 'lastname'=> 'Bot']);
		$user->setPassword ('secret');
		
		Account::first()
			->users()
			->save ($user);
    }
}