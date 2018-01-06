<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('assignments', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("language");
            $table->dateTime("startlaunch");
            $table->dateTime("endlaunch");
            $table->integer('fullscore');
            $table->integer('getscore');
            $table->integer('attempts');
            $table->string("fpath");
            $table->string("createby");
            $table->boolean("allow_send");
            $table->dateTime("created");
            $table->dateTime("modified");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
