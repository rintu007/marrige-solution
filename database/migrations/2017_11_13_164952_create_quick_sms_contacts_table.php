<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuickSmsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_sms_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quick_sms_contact_bulk_id')
                  ->unsigned()
                  ->nullable();
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
        Schema::dropIfExists('quick_sms_contacts');
    }
}
