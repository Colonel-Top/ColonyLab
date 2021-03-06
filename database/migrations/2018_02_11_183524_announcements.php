<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Announcements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         Schema::create('announcements', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("create_by");
            $table->string("live");
            $table->string("endtime")->nullable();
            $table->string("courses_id")->index();
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
         Schema::dropIfExists('announcements');
    }
}
