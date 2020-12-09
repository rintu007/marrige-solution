<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('education_level')->nullable();
            $table->string('education_level_other')->nullable();
            $table->string('subject_studied')->nullable();
            $table->string('job_title')->nullable();
            $table->string('my_profession')->nullable();
            $table->string('my_profession_other')->nullable(); //specify
            $table->string('first_language')->nullable();
            $table->string('second_language')->nullable();
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
        Schema::dropIfExists('user_educations');
    }
}
