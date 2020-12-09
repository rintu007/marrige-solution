<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sms_contact_bulk_id')
                  ->unsigned()
                  ->nullable();
            $table->integer('directory_id')
                  ->unsigned()
                  ->nullable();
            $table->string('verified_phone');
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
        Schema::dropIfExists('sms_contacts');
    }
}
