<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEnquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(Enquiry $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->markdown('emails.enquiries.new-enquiry')
                    ->subject('New Enquiry Received')
                    ->with([
                        'enquiry' => $this->enquiry,
                        'url' => route('enquiries.show', $this->enquiry->id)
                    ]);
    }
} 