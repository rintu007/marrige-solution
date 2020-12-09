<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title') //name of author
                  ->index()
                  ->nullable();
            $table->string('role_name')->nullable(); //role name in company, ceo, founder, chairman etc
            $table->text('description')
                  ->nullable();
            $table->string('feature_img_name')
                  ->nullable();
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
        Schema::dropIfExists('author_posts');
    }
}
