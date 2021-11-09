<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();

            $table->string("name"); // Name of the plan. Main is the name of subscription. Main subscrip, basic plan
            $table->string("amount");
            $table->string("interval");
            $table->string("description");

            $table->string("first_payment_webhook_url");
            $table->string("first_payment_redirect_url");
            $table->string("first_payment_amount");
            $table->string("first_payment_description");

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
        Schema::dropIfExists('payment_plans');
    }
}
