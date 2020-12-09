<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestCallBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_call_backs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('profilemadeby');
            $table->string('mobile',20);
            $table->string('email',191);
            $table->text('description')->nullable();
            $table->string('img_name')->nullable();
            $table->string('picture_name')->nullable();
            $table->string('img_url')->nullable();
            $table->string('pic_url')->nullable();
            $table->boolean('completed');
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
        Schema::dropIfExists('request_call_backs');
    }
}
