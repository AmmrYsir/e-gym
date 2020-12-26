<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription', function (Blueprint $table) {
            $table->id();
            $table->string('name', 24)->unique();
            $table->string('desc', 124);
            $table->integer('trial_able')->length(1)->unsigned()->default(0);
            $table->integer('trial_duration_in_weeks')->length(2)->nullable();
            $table->integer('parent_id')->length(5)->unsigned()->default(0);
            $table->Biginteger('type')->unsigned()->index();
            $table->json('duration')->nullable();
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
        Schema::dropIfExists('subscription');
    }
}