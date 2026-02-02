<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivateAccountClient extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $token = null;

    public $nomClient = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token, ?string $nomClient = null)
    {
        $this->token = $token;
        $this->nomClient = $nomClient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.activate-account-client');
    }
}
