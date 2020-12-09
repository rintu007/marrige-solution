<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chatto_id')
                  ->unsigned();
            $table->string('chatto_type'); 
            $table->integer('chatby_id')
                  ->unsigned();
            $table->string('chatby_type');
            //user cart shop product
            $table->integer('chat_id')
                  ->unsigned();
            $table->boolean('autoload');
            $table->boolean('box');
            $table->boolean('leaved');
            $table->string('status')
                  ->default('regular');
            $table->integer('addedby_id')
                  ->unsigned()
                  ->nullable();
            //regular archive unknown
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
        Schema::dropIfExists('chatables');
    }
}
