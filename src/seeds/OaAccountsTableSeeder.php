<?php
namespace Cloudoki\OaStack\Seeds;

use Cloudoki\OaStack\Models\Account;
use Illuminate\Database\Seeder;

class OaAccountsTableSeeder extends Seeder
{
    public function run()
    {
       Account::create(['name' => 'Acme', 'slug' => 'acme']);
    }
}