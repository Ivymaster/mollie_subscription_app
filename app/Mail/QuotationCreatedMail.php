<?php

namespace App\Mail;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Quotation $new_quotation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Quotation $new_quotation)
    {
        $this->new_quotation = $new_quotation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.quotations.created', [
            "quotation" => $this->new_quotation
        ]);
    }
}
