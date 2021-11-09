<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $except = [
        "https://samonapredak.com/webhooks/mollie",
        "https://samonapredak.com/webhooks/mollie",
        "https://samonapredak.com/webhooks/mollie/first-payment",
        'https://samonapredak.com/paypal-payment-successful',
        'https://samonapredak.com/paypal-payment-cancelled.html',
        'https://samonapredak.com/paypal-payment'
    ];
}
