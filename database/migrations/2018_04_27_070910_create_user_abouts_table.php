<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_abouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('headline')->nullable();
            $table->string('about_me')->nullable();
            //looking_for in users table  
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_abouts');
    }
}
