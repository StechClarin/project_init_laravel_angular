<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable;
/**
 * The password reset token.
 *
 * @var string
 */
    public $token;

/**
 * Create a new notification instance.
 *
 * @return void
 */ 
public function __construct($token)
{
    $this->token = $token;
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
        return (new MailMessage)   
                    ->subject('lien de reinitialisation du mot de passe')
                     ->greeting('Hello, '.$notifiable->name)
                    ->line('Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte. Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe')
                    ->action('Reinitialiser ', url('reset-password', $this->token))
                    ->line("Si vous n'avez pas demandé la réinitialisation du mot de passe, aucune autre action n'est requise.")   
                    ->salutation('Merci !'); 
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
