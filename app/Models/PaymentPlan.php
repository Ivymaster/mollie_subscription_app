<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Plan\Plan as CashierPlan;
use Laravel\Cashier\Order\OrderItemPreprocessorCollection;
use Laravel\Cashier\Coupon\CouponOrderItemPreprocessor as ProcessCoupons;
use Laravel\Cashier\Order\PersistOrderItemsPreprocessor as PersistOrderItems;

class PaymentPlan extends Model
{
    use HasFactory;

        /**
     * Builds a Cashier plan from the current model.
     *
     * @returns \Laravel\Cashier\Plan\Plan
     */
    public function buildCashierPlan(): CashierPlan
    {
        $plan = new CashierPlan($this->name);

        $payment_amount = [
            "value" => $this->amount,
            "currency" => "EUR"
        ];
        return $plan->setAmount(mollie_array_to_money($payment_amount))
            ->setInterval($this->interval)
            ->setDescription($this->description)
            ->setFirstPaymentMethod($this->first_payment_method)
            ->setFirstPaymentAmount(mollie_array_to_money($payment_amount))
            ->setFirstPaymentDescription($this->first_payment_description)
            ->setFirstPaymentRedirectUrl($this->first_payment_redirect_url)
            ->setFirstPaymentWebhookUrl($this->first_payment_webhook_url)
            ->setOrderItemPreprocessors((OrderItemPreprocessorCollection::fromArray([ProcessCoupons::class, PersistOrderItems::class])));
    }
}
