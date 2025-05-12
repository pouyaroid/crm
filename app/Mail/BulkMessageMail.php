<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class BulkMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $messageText;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $messageText)
    {
        $this->customer = $customer;
        $this->messageText = $messageText;
    }

    public function build()
    {
        return $this->subject('مشتری گرامی')
                    ->view('emails.bulk-message')
                    ->with([
                        'customer' => $this->customer,
                        'messageText' => $this->messageText,
                    ]);
    }
}