<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('touches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')
                  ->unsigned();
            $table->string('notify_type');
            //shop,message,main,frtm
            $table->integer('notify_value')
                  ->unsigned()
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('touches');
    }
}
