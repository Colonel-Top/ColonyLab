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
            $table->integer("courses_id")->unsigned();
            $table->string("language");
            $table->dateTime("starttime")->nullable();
            $table->dateTime("endtime")->nullable();
            $table->integer('fullscore')->nullable();
            //$table->integer('getscore')->nullable();
            $table->integer('max_attempts')->nullable();
            $table->string("fpath")->nullable();
            $table->string("finput")->nullable();
            $table->string("finput2")->nullable();
            $table->string("finput3")->nullable();
            $table->string("finput4")->nullable();
            $table->string("finput5")->nullable();
            $table->string("foutput")->nullable();
            $table->string("foutput2")->nullable();
            $table->string("foutput3")->nullable();
            $table->string("foutput4")->nullable();
            $table->string("foutput5")->nullable();
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
