<?php

namespace JoshuaBedford\LaravelWordFilter\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with the whitelist/blacklist
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	BlacklistSeeder::class,
        	// WhitelistSeeder::class
        ]);
    }
}
