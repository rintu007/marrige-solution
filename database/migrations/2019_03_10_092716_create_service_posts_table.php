<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')
                  ->index()
                  ->nullable();
            $table->text('description')
                  ->nullable();
            $table->string('feature_img_name')
                  ->nullable();
            $table->string('url')->nullable();
            $table->string('button_text')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('addedby_id')
                  ->unsigned()
                  ->nullable();
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
        Schema::dropIfExists('service_posts');
    }
}
