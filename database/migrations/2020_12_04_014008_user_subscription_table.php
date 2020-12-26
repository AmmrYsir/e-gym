<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription', function (Blueprint $table) {
            $table->id();
            $table->Biginteger('user_id')->unsigned()->nullable();
            $table->Biginteger('subscription_id')->unsigned();
            $table->char('status', 1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id')->references('id')->on('subscription')->onDelete('cascade');
            $table->integer('duration')->length(10)->nullable();
            $table->integer('trial')->length(1)->nullable();
            $table->timestamp('subscription_start')->nullable();
            $table->timestamp('subscription_end')->nullable();
            $table->timestamp('trial_end')->nullable();
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
        Schema::dropIfExists('user_subscription');
    }
}