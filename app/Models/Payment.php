<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "mollie_payment_id",
        "mollie_profile_id",
        "mode",
        "amount_value",
        "amount_currency",
        "description",
        "payment_created_at",
        "payment_paid_at",
        "country_code",
    ];

}
