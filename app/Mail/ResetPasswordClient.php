<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordClient extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $token = null;

    public $nomComplet = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $token, ?string $nomComplet = null)
    {
        $this->token = $token;
        $this->nomComplet = $nomComplet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.auth.reset-password-client');
    }
}
