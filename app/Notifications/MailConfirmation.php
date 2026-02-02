<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MailConfirmation extends Notification
{
    use Queueable;
    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        //
        $this->password = $password;

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
        $url = url(config('env.FRONT_URL')."/index.html?tokenactivationmikado=".bcrypt($notifiable->email)."_".$notifiable->id);

        return (new MailMessage)
            ->view('mails.activation_compte',array(
                'nom'            => $notifiable->nom_complet,
                'email'          => $notifiable->email,
                'password'       => $this->password,
                'url'            => $url
            ))
            ->subject('Confirmation du compte');
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
