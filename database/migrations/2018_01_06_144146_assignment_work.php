<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('assignment_work', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('users_id');
            $table->string('scores');
            //$table->string('assignment_id');
            $table->string('enrollments_id');
            
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
        //
    }
}
