<?php

namespace App\Http\Controllers;

 use App\Models\PaymentPlan;
use Illuminate\Http\Request;

class PaymentPlanController extends Controller
{
    public function change_plans(Request $request){
        $plan = PaymentPlan::find($request->plan_id);
         if(auth()->user()->subscribed("main")){
            auth()->user()->subscription('main')->swap($plan->name);
        }else{
            $result = auth()->user()->newSubscription('main', $plan->name)->trialUntil(now()->addDays(1))->create();

            //if(is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            //}

            return back()->withMessage('Welcome to the ' . $request->name . ' plan');
        }

        return back()->withMessage("Succesfully changed the plans");

    }
}
