<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')
                  ->unsigned();
            $table->string('file_name')
                  ->nullable()
                  ->index();
            $table->string('original_name')
                  ->nullable();
            $table->string('file_mime')
                  ->nullable();
            $table->string('file_ext')->nullable();
            $table->string('file_alt')->nullable();
            $table->integer('file_size')
                  ->nullable();
            $table->string('file_type'); 
            //image video pdf audio
            $table->integer('addedby_id')
                  ->unsigned();
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('message_id')
            //       ->references('id')
            //       ->on('messages')
            //       ->onDelete('cascade')
            //       ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_files');
    }
}
