<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReligionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_religions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('religious_status')->nullable();
            $table->string('religious_section')->nullable();
            $table->string('prefer_hijab')->nullable();
            $table->string('prefer_beard')->nullable();
            $table->string('are_you_revert')->nullable();
            $table->string('salah_status')->nullable();
            $table->string('can_read_quran')->nullable();
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
        Schema::dropIfExists('user_religions');
    }
}
