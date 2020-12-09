<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal_infos', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('citizenship')->nullable();
            // $table->string('citizenship_other')->nullable();
            // $table->string('birth_place')->nullable();
            // $table->string('income')->nullable();
            // $table->string('going_to_marry')->nullable(); //this year,..
            $table->string('marital_status')->nullable(); #
            // $table->string('like_to_have_children')->nullable(); 
            $table->string('do_u_have_children')->nullable(); #
            // $table->string('living_with')->nullable();
            // $table->string('living_with_other')->nullable(); //specify
            $table->string('height')->nullable(); #ok
            $table->string('body_build')->nullable(); #ok
            $table->string('hair_color')->nullable(); #ok
            $table->string('hair_color_other')->nullable(); #ok
            $table->string('eye_color')->nullable(); #ok
            $table->string('eye_color_other')->nullable(); #ok
            $table->string('skin_color')->nullable(); #ok
            $table->string('skin_color_other')->nullable(); #ok
            // $table->string('dress_up')->nullable(); 
            // $table->string('dress_up_other')->nullable(); 
            $table->string('zodiac_sign')->nullable(); #ok
            $table->string('smoke_status')->nullable(); #ok
            $table->string('disabilities_status')->nullable(); #ok
            $table->string('disabilities_status_other')->nullable(); #ok
            // $table->string('how_many_siblings')->nullable(); 
            // $table->string('how_many_siblings_other')->nullable();
            $table->string('alcohol_status')->nullable(); #ok
            $table->string('diat_status')->nullable(); #ok
            $table->string('blood_group')->nullable(); #ok


            $table->string('education_level')->nullable(); #ok
            $table->string('education_level_other')->nullable(); #ok
            $table->string('major_subject')->nullable(); #ok
            $table->string('graduate_from')->nullable(); #ok

            $table->string('job_title')->nullable();#ok
            $table->string('my_profession')->nullable();#ok
            $table->string('my_profession_other')->nullable();#ok
            $table->string('job_company_name')->nullable();#ok
            $table->string('income')->nullable();#ok

            $table->string('mother_tongue')->nullable(); #ok
            $table->string('can_speak')->nullable(); #ok

            // $table->string('more_about_yourself')->nullable();
            // $table->string('family_background')->nullable();
            $table->string('father_name')->nullable();#ok
            $table->string('father_occupation')->nullable();#ok
            $table->string('mother_name')->nullable();#ok
            $table->string('mother_occupation')->nullable();#ok
            $table->string('number_of_brother')->nullable();#ok
            $table->string('how_many_brother_married')->nullable();#ok
            $table->string('number_of_sister')->nullable();#ok
            $table->string('how_many_sister_married')->nullable();#ok

            $table->string('division')->nullable();#ok
            $table->string('district')->nullable();#ok
            $table->string('thana')->nullable();#ok
            $table->string('zip_code')->nullable();#ok

            $table->string('citizenship')->nullable();#ok
            $table->string('citizenship_other')->nullable();#ok
            $table->string('city_of_residence')->nullable();#ok
            $table->string('state_of_residence')->nullable();#ok
            $table->string('country_of_residence')->nullable();#ok
            $table->string('country_of_residence_other')->nullable();#ok

            $table->string('hear_about_us')->nullable(); #ok

            $table->boolean('checked')->default(0);
            $table->boolean('can_edit')->default(1);
            $table->integer('user_id')->unsigned();
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();

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
        Schema::dropIfExists('user_personal_infos');
    }
}
