<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
    public $nom;
    public $telephone;
    public $message;
    public $email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nom,$telephone,$message,$email)
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@mikado.com')->view('mails.contact',
          [
              'email'           => $this->email,
              'nom'             => $this->nom,
              'telephone'       => $this->telephone,
              'msg'             => $this->message,
          ]);
    }
}
