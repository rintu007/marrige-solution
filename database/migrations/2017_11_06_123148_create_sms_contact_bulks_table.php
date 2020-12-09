<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsContactBulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_contact_bulks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category')->nullable();
            $table->string('thana')->nullable();
            $table->string('sent_from')->nullbale();
            $table->string('message')->nullable();
            $table->integer('addedby_id')
                  ->unsigned()
                  ->nullable();
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
        Schema::dropIfExists('sms_contact_bulks');
    }
}
