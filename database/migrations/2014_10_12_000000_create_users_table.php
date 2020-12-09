<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); //ok
            $table->string('mobile')->nullable(); //ok
            $table->string('guardian_mobile')->nullable();
            $table->string('username')->nullable(); //ok
            $table->string('email')->nullable(); //ok
            $table->string('password'); //ok
            $table->string('password_temp')->nullable();

            $table->boolean('active')->default(1); //ok
            $table->char('gender', 10)->nullable(); //male female other //ok

            // $table->string('location')->nullable(); //district thana other
            
            $table->string('country')->nullable(); //ok
            $table->string('country_other')->nullable(); 
            

            $table->string('profile_created_by')->nullable(); //ok
            $table->string('profile_created_by_other')->nullable();
            $table->string('religion')->nullable(); //community //ok

            $table->string('social_order')->nullable(); //caste
            $table->string('looking_for')->nullable(); //girl boy other //ok
            $table->date('dob')->nullable(); //date of birth //ok
            $table->integer('sms_count')->default(0);
            $table->boolean('checked')->default(0);
            $table->boolean('final_checked')->default(0);
            $table->boolean('featured')->default(0);


            $table->string('img_name')->nullable(); //feature image name

            $table->string('file_name')->nullable();//cv
            $table->string('file_ext')->nullable(); //cv

            $table->boolean('cv_checked')->default(0); 
 
            
            $table->string('user_type')->default('online');
            //online offline
            $table->boolean('can_edit')->default(1);
            $table->integer('addedby_id')->unsigned()->default(1);
            $table->integer('editedby_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->integer('package')->default(0); //package 1, 2, 3, 4
            $table->timestamp('expired_at')->nullable();
            $table->timestamp('loggedin_at')->nullable();
            $table->timestamp('inactive_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
