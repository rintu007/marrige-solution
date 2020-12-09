<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_title')
                  ->nullable()
                  ->index();
            $table->string('message_slug')
                  ->nullable()
                  ->index();
            $table->text('message_body')
                  ->nullable();
            $table->integer('chat_id')
                  ->unsigned();
            $table->integer('addedby_id')
                  ->unsigned();
            $table->integer('editedby_id')
                  ->unsigned()
                  ->nullable()
                  ->default(NULL);
            $table->string('message_status') //temp, draft, published
                  ->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('addedby_id')
            //       ->references('id')
            //       ->on('users')
            //       ->onDelete('cascade');
            // $table->foreign('chat_id')
            //       ->references('id')
            //       ->on('chats')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
