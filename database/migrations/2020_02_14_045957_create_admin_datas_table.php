<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_pending')->default(0);
            $table->integer('not_checked')->default(0);
            $table->integer('less_than_ten')->default(0);
            $table->integer('free_pack')->default(0);
            $table->integer('pending_payment')->default(0);
            $table->integer('proposal_unchecked')->default(0);
            $table->integer('create_today')->default(0);
            $table->integer('create_this_month')->default(0);
            $table->integer('deactive_today')->default(0);
            $table->integer('deactive_this_month')->default(0);
            $table->integer('all_users')->default(0);
            $table->integer('online_users')->default(0);
            $table->integer('female_users')->default(0);
            $table->integer('male_users')->default(0);
            $table->integer('subscribers')->default(0);
            $table->integer('diamond_plus_users')->default(0);
            $table->integer('diamond_users')->default(0);
            $table->integer('golden_plus_users')->default(0);
            $table->integer('golden_users')->default(0);
            $table->integer('order_by_age_users')->default(0);

            $table->integer('deactivate_users')->default(0);
            $table->integer('complains')->default(0);
            $table->integer('pending_payment_today')->default(0);
            $table->integer('pending_payment_this_month')->default(0);
            $table->integer('paid_payment_today')->default(0);
            $table->integer('paid_payment_this_month')->default(0);
            $table->integer('cv_new_pending')->default(0);
            $table->integer('log_user_count')->default(0);
            $table->integer('logs_count')->default(0);

            $table->timestamp('dashboard_updated_at')->nullable();
            
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
        Schema::dropIfExists('admin_datas');
    }
}
