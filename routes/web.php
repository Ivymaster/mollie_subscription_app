<?php

use App\Http\Controllers\PaymentPlanController;
use App\Http\Controllers\PayPalController;
use App\Models\Payment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;
use Mollie\Laravel\Facades\Mollie;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Http\Controllers\FirstPaymentWebhookController;
use Laravel\Cashier\Http\Controllers\WebhookController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::middleware("role:admin|creator")->get('/home', App\Http\Controllers\HomeController::class)->name('home');

/////////////////////////////////////////////////////////////////////////////
/* PAYPAL */
Route::get("paypal-payment-successful", function () {
    dd("success");
})->name("paypal.payment_successful");
Route::get("paypal-payment-cancelled", function () {
    dd("cancell");
})->name("paypal.payment_cancelled");
Route::post("paypal-payment", [PayPalController::class, "payment"])->name("paypal.payment");
/////////////////////////////////////////////////////////////////////////////

Auth::routes();
/////////////////////////////////////////////////////////////////////////////

/* MOLLIE */
Route::post('/mollie-payment', function (Request $request) {
    $request->validate([
        "price" => ["required", "numeric"]
    ]);
    $payment = Mollie::api()->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" =>  number_format($request->price, 2) // You must send the correct number of decimals, thus we enforce the use of strings
        ],
        "description" => "Testing the onetime payment",
        "redirectUrl" => route('mollie.order.success'),
        "webhookUrl" => route('webhooks.mollie'),
        "metadata" => [
            "user_id" => auth()->id(),
        ],
    ]);

    // redirect customer to Mollie checkout page
    return redirect($payment->getCheckoutUrl(), 303);
})->name("mollie.payment");


/*MOLLIE OCURRENT PAYMENT - LARAVEL CASHIER*/
Route::get('/webhooks/mollie/first-payment', function () {
    Log::info("Prvo plaćanje");
})->name('webhooks.mollie.first_payment');

/*MOLLIE SINGLE PAYMENT*/
//Route::post('/webhooks/mollie', [WebhookController::class, "handleWebhook"])->name('webhooks.mollie');

Route::post('/webhooks/mollie', function (Request $request) {
    $paymentId = $request->input('id');
    $payment = Mollie::api()->payments->get($paymentId);

    if ($payment->isPaid()) {
        Log::info(json_encode($payment));
        Payment::create([
            "user_id" => $payment->metadata->user_id,
            "mollie_payment_id" => $payment->id,
            "mollie_profile_id" => $payment->profileId,
            "mode" => $payment->mode,
            "amount_value" => $payment->amount->value,
            "amount_currency" => $payment->amount->currency,
            "description" => $payment->description,
            "payment_created_at" => \Carbon\Carbon::parse($payment->createdAt),
            "payment_paid_at" => \Carbon\Carbon::parse($payment->paidAt),
            "country_code" => $payment->countryCode,
        ]);
    }
})->name('webhooks.mollie');
/////////////////////////////////////////////////////////////////////////////

Route::get('/mollie-order-success', function () {
    return redirect()->route("home");
})->name('mollie.order.success');

Route::get("/cashier-update", function () {
    Artisan::call("cashier:run");
    Log::info("Cashier app is updated");
    return "Updated";
});
Route::post("/change-payment-plans", [PaymentPlanController::class, "change_plans"])->name("change_plans");
/////////////////////////////////////////////////////////////////////////////

/* QUOTES */
Route::get('/quotations/{quotation}/print', function (Request $request) {
    $fpdf = new Fpdf("P", "mm", "A4");
    $fpdf->AddPage();
    $fpdf->SetFont('Courier', 'B', 18);
    $fpdf->Cell(50, 25, 'Quote', 0, 2);
    // $fpdf->Cell(0, 25, $quotation->body, 0, 2);
    // $fpdf->Cell(0, 25, $quotation->formatted_price . chr(128));
    $fpdf->Output();
    exit;
});
/////////////////////////////////////////////////////////////////////////////

/* DONATIONS */
Route::get("/donations", function () {
    if (auth()->user()->hasRole("admin")) {
        $donations = Payment::join("users", "payments.user_id", "=", "users.id")->get();
    } else {
        $donations = Payment::where("user_id", auth()->id())->get();
    }
    return view("creator.donations.index", [
        "donations" => $donations,
    ]);
})->name("donations");
/////////////////////////////////////////////////////////////////////////////


/* SUBSCRIPTIONS */
Route::get("/subscriptions", function () {
    if (!auth()->user()->hasRole("admin")) {
        return redirect("/")->withMessage("You have no acces rights here!");
    }

    $subscriptions = DB::table("subscriptions")->join("users", "users.id", "=", "subscriptions.owner_id")->select("users.name as user_name", "subscriptions.*")->get();

    return view("creator.subscriptions.index", [
        "subscriptions" => $subscriptions,
    ]);
})->name("subscriptions");

Route::get("/subscriptions/cancel", function () {
    auth()->user()->subscription('main')->cancel();
    return redirect("/");
})->name("subscriptions.cancel");

Route::get("/subscriptions/resume", function () {
    auth()->user()->subscription('main')->resume();
    return redirect("/");
})->name("subscriptions.resume");
/////////////////////////////////////////////////////////////////////////////
