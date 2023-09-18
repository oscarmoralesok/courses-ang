<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactNotification extends Notification
{
    use Queueable;

    protected $arrayContact;

    public function __construct( $arrayContact )
    {
        $this -> arrayContact = $arrayContact;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->replyTo($this -> arrayContact['email'])
                    ->subject('Mensaje de contacto')
                    ->line('Nombre: ' . $this -> arrayContact['name'])
                    ->line('Email: ' . $this -> arrayContact['email'])
                    ->line('Mensaje: ' . $this -> arrayContact['message']);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
