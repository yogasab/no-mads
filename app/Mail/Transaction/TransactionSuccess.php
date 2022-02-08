<?php

namespace App\Mail\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $title;
    public $departure_date;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction, $title, $departure_date)
    {
        $this->transaction = $transaction;
        $this->title = $title;
        $this->departure_date = $departure_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->transaction->travel_package['title']);
        return $this->from('no-reply@nomads.com', 'NOMADS')
            ->subject('NOMADS E-Ticket')
            ->view('mail.checkout.checkout');
    }
}
