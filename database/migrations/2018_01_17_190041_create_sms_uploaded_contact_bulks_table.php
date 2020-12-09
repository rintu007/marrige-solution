<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsUploadedContactBulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_uploaded_contact_bulks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sent_from')->nullbale();
            $table->string('title')->nullbale(); //file name or title or description about the file
            $table->string('message')->nullable();
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
        Schema::dropIfExists('sms_uploaded_contact_bulks');
    }
}
