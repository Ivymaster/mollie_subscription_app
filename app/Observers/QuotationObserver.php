<?php

namespace App\Observers;

use App\Mail\QuotationCreatedMail;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QuotationObserver
{
    /**
     * Handle the Quotation "created" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function created(Quotation $quotation)
    {
        Log::info("Created a new quotation. Name: " . $quotation->body . ", and price: " . $quotation->price);

        $admin_emails = User::whereRoleIs("admin")->get(["email"]);

        foreach ($admin_emails as $admin_email){
            Mail::to($admin_email)->send(new QuotationCreatedMail($quotation));
        }
    }

    /**
     * Handle the Quotation "updated" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function updated(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the Quotation "deleted" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function deleted(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the Quotation "restored" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function restored(Quotation $quotation)
    {
        //
    }

    /**
     * Handle the Quotation "force deleted" event.
     *
     * @param  \App\Models\Quotation  $quotation
     * @return void
     */
    public function forceDeleted(Quotation $quotation)
    {
        //
    }
}
