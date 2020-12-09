<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsUploadedContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_uploaded_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sms_uploaded_contact_bulk_id')
                  ->unsigned()
                  ->nullable();
            $table->string('name')->nullable(); //Person's Name
            $table->string('company')->nullable();
            $table->string('area')->nullable();
            $table->string('mobile');
            $table->string('status')->default('temp'); //temp,draft,sent,
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
        Schema::dropIfExists('sms_uploaded_contacts');
    }
}
