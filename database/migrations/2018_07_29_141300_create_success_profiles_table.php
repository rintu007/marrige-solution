<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuccessProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('success_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('location')->nullable();
            $table->string('bride_username')->nullable();
            $table->string('groom_username')->nullable();
            $table->date('marriage_date')->nullable();
            $table->text('description')->nullable();
            $table->string('image_name')->nullable();
            $table->integer('addedby_id')
                  ->unsigned();
            $table->integer('editedby_id')
                  ->unsigned()
                  ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('success_profiles');
    }
}
