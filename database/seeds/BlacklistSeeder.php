<?php

use Illuminate\Database\Seeder;

class BlacklistSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $blacklist = file_get_contents("https://raw.githubusercontent.com/zacanger/profane-words/master/words.json");
        echo $blacklist;
    }
}
