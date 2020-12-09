<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersForAutoMailItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_for_auto_mail_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('automail_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('user_second_id')->unsigned();
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
        Schema::dropIfExists('users_for_auto_mail_items');
    }
}
