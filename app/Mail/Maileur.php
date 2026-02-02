<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Maileur extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private  $sujet;
    private  $texte;
    private  $page;
    private  $pdfPaths = []; // Tableau de chemins de fichiers

    public function __construct($sujet, $texte, $pdfPaths, $page = 'rapport')
    {
        $this->sujet = $sujet;
        $this->texte = $texte;
        $this->pdfPaths = is_array($pdfPaths) ? $pdfPaths : [$pdfPaths];
        $this->page = $page;
    }

    public function build()
    {
        $email = $this->from('contactimaara@gmail.com')
            ->subject($this->sujet)
            ->view('emails.'.$this->page, [
                'texte' => $this->texte
            ]);
            
        // Ajout des pièces jointes
        foreach ($this->pdfPaths as $pdfPath) {
            if (file_exists($pdfPath)) {
                $email->attach($pdfPath, [
                    'as' => basename($pdfPath),
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $email;
    }
}
