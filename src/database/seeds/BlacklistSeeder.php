<?php

namespace JoshuaBedford\LaravelWordFilter\Database\Seeds;

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
        $tableNames = config('word.table_names');
        
        $blacklist = json_decode(file_get_contents("https://raw.githubusercontent.com/JoshuaBedford/filter-words/master/blacklist.json"));

        $id = 1;
        $type = "profanity";
        $data = [];

        foreach($blacklist as $word){

            $temp = [
                "word" => $word,
                "type" => $type
            ];
            array_push($data, $temp);
        }

        \DB::table($tableNames['blacklist'])->insert($data);
    }
}
