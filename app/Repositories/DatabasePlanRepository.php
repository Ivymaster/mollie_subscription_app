<?php
namespace App\Repositories;

use App\Models\PaymentPlan;
use Laravel\Cashier\Exceptions\PlanNotFoundException;
use Laravel\Cashier\Plan\Contracts\PlanRepository;

class DatabasePlanRepository implements PlanRepository
{
    public static function find(string $name)
    {
        $plan = PaymentPlan::where('name', $name)->first();

        if (is_null($plan)) {
            return null;
        }

        // Return a \Laravel\Cashier\Plan\Plan by creating one from the database values
        return $plan->buildCashierPlan();

        // Or if your model implements the contract: \Laravel\Cashier\Plan\Contracts\Plan
        return $plan;
    }

    public static function findOrFail(string $name)
    {
        if (($result = self::find($name)) === null) {
            throw new PlanNotFoundException;
        }

        return $result;
    }
}
