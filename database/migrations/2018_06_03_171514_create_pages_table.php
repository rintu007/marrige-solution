<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_title')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            $table->string('page_type')->default('Full Page'); //Part Page, Full Page
            $table->string('route_name')->nullable();
            $table->text('content')->nullable();
            $table->boolean('title_hide')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('editor')->default(1);
            $table->boolean('list_in_menu')->default(0);
            $table->boolean('left_sidebar')->default(1);
            $table->integer('addedby_id')
                  ->unsigned();
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
        Schema::dropIfExists('pages');
    }
}
