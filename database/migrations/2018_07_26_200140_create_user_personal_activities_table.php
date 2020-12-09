<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPersonalActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal_activities', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('interests')->nullable();
            $table->string('favourite_music')->nullable();
            $table->string('favourite_reads')->nullable();
            $table->string('favourite_movies')->nullable();
            $table->string('favourite_cooking')->nullable();
            $table->string('dress_style')->nullable();

            $table->boolean('checked')->default(0);
            $table->boolean('can_edit')->default(1);
            $table->integer('user_id')->unsigned();
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();

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
        Schema::dropIfExists('user_personal_activities');
    }
}
