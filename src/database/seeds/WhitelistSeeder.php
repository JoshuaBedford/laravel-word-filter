<?php

namespace JoshuaBedford\LaravelWordFilter\Database\Seeds;

use Illuminate\Database\Seeder;

class WhitelistSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$tableNames = config('word.table_names');

        $whitelist = json_decode(file_get_contents("https://raw.githubusercontent.com/JoshuaBedford/filter-words/master/whitelist.json"));

        $id = 1;
        $type = "profanity";
        $data = [];

        foreach($whitelist as $word){

            $temp = [
                "word" => $word,
                "type" => $type
            ];
            array_push($data, $temp);
        }

        \DB::table($tableNames['whitelist'])->insert($data);
    }
}
