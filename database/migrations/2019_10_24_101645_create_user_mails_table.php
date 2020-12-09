<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_mails', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id') //main user
                  ->unsigned();
            $table->bigInteger('user_to_id')
                  ->unsigned(); 

            //cv sent by mail from user_id to offline users or to online users
            //cv sent by mail to user_id from offline users or from online users
            $table->integer('sent_count')->default(0);
            $table->bigInteger('addedby_id')->unsigned();
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
        Schema::dropIfExists('user_mails');
    }
}
