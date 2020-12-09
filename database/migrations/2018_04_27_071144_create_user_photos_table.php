<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_name')->nullable();
            $table->string('img_original_name')->nullable();
            $table->string('img_url')->nullable();
            $table->string('img_size')->nullable(); //in kb
            $table->string('img_width')->nullable();
            $table->string('img_height')->nullable();
            $table->string('img_ext')->nullable();
            $table->string('img_mime')->nullable();
            $table->string('img_type')->nullable(); //profile,cover,normal
            $table->boolean('autoload')->default(1);
            $table->boolean('checked')->default(0);
            $table->boolean('can_edit')->default(1);
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
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
        Schema::dropIfExists('user_photos');
    }
}
