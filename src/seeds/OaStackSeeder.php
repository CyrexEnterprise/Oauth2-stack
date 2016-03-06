<?php
namespace Cloudoki\OaStack\Seeds;

use Illuminate\Database\Seeder;

class OaStackSeeder extends Seeder 
{
    public function run()
    {
        $this->call(OaAccountsTableSeeder::class);
        $this->call(OaUsersTableSeeder::class);
        $this->call(OauthClientsTableSeeder::class);

        $this->command->info('OaStack tables seeded!');
    }
}