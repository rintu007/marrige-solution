<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSearchTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_search_terms', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('custom_search')->default(1);
            $table->integer('min_age')->default(18);
            $table->integer('max_age')->default(60);
            // $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->string('country_other')->nullable();
            $table->string('country_of_residence')->nullable();
            $table->string('country_of_residence_other')->nullable();

            // $table->string('location')->nullable(); //district thana other
            $table->string('user_status')->nullable(); //with pic, online, new, premium, most active,


            // $table->string('name')->nullable();
            // $table->string('mobile')->nullable();
            // $table->string('username')->nullable();
            // $table->string('email')->nullable();

            // $table->boolean('active')->default(1);
            // $table->string('reason_for_register')->nullable();
            // $table->string('looking_for')->nullable(); //girl boy other


            $table->string('education_level')->nullable();
            $table->string('subject_studied')->nullable();
            $table->string('job_title')->nullable();

            $table->string('my_profession')->nullable();
            $table->string('my_profession_other')->nullable(); //specify
            // $table->string('first_language')->nullable();
            // $table->string('second_language')->nullable();
            $table->string('citizenship')->nullable();
            // $table->string('birth_place')->nullable();
            $table->string('income')->nullable();
            // $table->string('going_to_marry')->nullable(); //this year,..
            $table->string('marital_status')->nullable();
            // $table->string('like_to_have_children')->nullable();
            $table->string('do_u_have_children')->nullable();
            // $table->string('living_with')->nullable();
            // $table->string('living_with_other')->nullable(); //specify
            // $table->string('height')->nullable();
            $table->string('body_build')->nullable();
            // $table->string('hair_color')->nullable();
            // $table->string('eye_color')->nullable();
            $table->string('skin_color')->nullable();
            // $table->string('dress_up')->nullable();
            $table->string('smoke_status')->nullable();
            $table->string('disabilities_status')->nullable();
            $table->string('disabilities_status_other')->nullable();
            // $table->string('how_many_siblings')->nullable();
            $table->string('alcohol_status')->nullable();
            $table->string('min_height')->nullable();
            $table->string('max_height')->nullable();


            $table->string('diat_status')->nullable();
            $table->string('mother_tongue')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('citizenship_other')->nullable();
            $table->string('city_of_residence')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('religion')->nullable();
            $table->string('social_order')->nullable();
            $table->string('interests')->nullable();
            $table->string('favourite_music')->nullable();
            $table->string('favourite_reads')->nullable();
            $table->string('favourite_movies')->nullable();
            $table->string('favourite_cooking')->nullable();
            $table->string('dress_style')->nullable();

            $table->boolean('checked')->default(0);
            $table->boolean('can_edit')->default(1);
            
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();


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
        Schema::dropIfExists('user_search_terms');
    }
}
