<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordListTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Let's fetch from our config what we want to name our tables.
        $tableNames = config('word.table_names');

        // Let's create the blacklist table.
        Schema::create($tableNames['blacklist'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('word');
            $table->string('type');
        });

        // Let's create the whitelist table.
        Schema::create($tableNames['whitelist'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('word');
            $table->string('type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Let's fetch our table names from config.
        $tableNames = config('word.table_names');

        // Let's drop the blacklist table.
        Schema::dropIfExists($tableNames['blacklist']);
        // Let's drop the whitelist table.
        Schema::dropIfExists($tableNames['whitelist']);
    }
}
