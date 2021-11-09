<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table("payment_plans")->insert([
            "name" => "basic",
            "amount" => "10",
            "interval" => "1 day",
            "description" => "Basic plan supscription",
            "first_payment_webhook_url" => env('APP_URL', null) . "/webhooks/mollie/first-payment",
            "first_payment_redirect_url" => env('APP_URL', null) . "/home",
            "first_payment_amount" => "0.01",
            "first_payment_description" => "This is the first payment, for the basic plan",
        ]);
        DB::table("payment_plans")->insert([
            "name" => "premium",
            "amount" => "20",
            "interval" => "1 day",
            "description" => "Premium plan supscription",
            "first_payment_webhook_url" => env('APP_URL', null) . "/webhooks/mollie/first-payment",
            "first_payment_redirect_url" => env('APP_URL', null) . "/home",
            "first_payment_amount" => "0.01",
            "first_payment_description" => "This is the first payment, for the premium plan",
        ]);
    }
}
