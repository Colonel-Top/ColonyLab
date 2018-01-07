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
            $table->string("courses_id");
            $table->string("language");
            $table->dateTime("starttime")->nullable();
            $table->dateTime("endtime")->nullable();
            $table->integer('fullscore')->nullable();
            //$table->integer('getscore')->nullable();
            $table->integer('max_attempts')->nullable();
            $table->string("fpath")->nullable();
            $table->string("input")->nullable();
            $table->string("foutput")->nullable();
            $table->string("createby");
            $table->boolean("allow_send");
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
