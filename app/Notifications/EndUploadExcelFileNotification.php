<?php

namespace App\Notifications;

use App\Models\Outil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EndUploadExcelFileNotification extends Notification
{
    use Queueable;

    private  $pdf;
    private  $items;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pdf, $items = "produits")
    {
        $this->pdf = $pdf;
        $this->items = $items;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(Outil::getAPI());

        //dd('ici');
        return (new MailMessage)
            ->subject("Rapport d'importation du fichier {$this->items}")
            ->greeting('Bonjour!')
            ->line("Nous faisons joindre au présent mail, le rapport d'importation du fichier {$this->items}")
            ->action('Connectez-vous', $url)
            ->line('Support technique de '.config('app.name').'!')
            ->attachData($this->pdf->output(),"rapport import fichier {$this->items}.pdf",[
                    'mime' => 'application/pdf']
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
