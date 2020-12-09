<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                  ->unsigned();
            $table->string('image_name')
                  ->nullable();
            $table->string('image_mime')
                  ->nullable();
            $table->string('image_ext')->nullable();
            $table->string('image_alt')->nullable();
            $table->integer('image_size')
                  ->nullable();
            $table->integer('image_width')
                  ->nullable();
            $table->integer('image_height')
                  ->nullable();
            $table->boolean('autoload');
            $table->boolean('checked')->default(0);
            $table->boolean('can_edit')->default(1);
            $table->string('image_type'); //profilepic, coverpic, privatepic
            $table->integer('editedby_id')
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
        Schema::dropIfExists('user_pictures');
    }
}
