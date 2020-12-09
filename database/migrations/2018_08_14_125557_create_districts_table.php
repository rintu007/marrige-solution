<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('division_id')->unsigned()->nullable();
            $table->string('name', 30)->nullable();
            $table->string('bn_name', 50)->nullable();
            $table->double('lat')->nullable();
            $table->double('lon')->nullable();
            $table->string('website',100)->nullable();
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();
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
        Schema::dropIfExists('districts');
    }
}
