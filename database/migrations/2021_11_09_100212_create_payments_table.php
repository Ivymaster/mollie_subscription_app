<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("user_id");

            $table->string("mollie_payment_id");
            $table->string("mollie_profile_id");
            $table->string("mode");
            $table->string("amount_value");
            $table->string("amount_currency");
            $table->string("description");
            $table->datetime("payment_created_at");
            $table->datetime("payment_paid_at");
            $table->string("country_code");

            $table->foreign("user_id")->references("id")->on("users");

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
        Schema::dropIfExists('payments');
    }
}
