<?php
namespace Cloudoki\OaStack\Seeds;

use Cloudoki\OaStack\Models\User;
use Illuminate\Database\Seeder;

class OaUsersTableSeeder extends Seeder 
{
    public function run()
    {
        User::create(['email' => 'jane@doe.com', 'firstname'=> 'Jane', 'lastname'=> 'Doe']);
    }
}