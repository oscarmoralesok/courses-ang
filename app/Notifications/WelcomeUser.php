<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification
{
    use Queueable;

    public $user, $password;

    public function __construct($user, $password)
    {
        $this -> user = $user;
        $this -> password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Bienvenido a ANG Courses')
                    ->greeting('¡Hola ' . $this -> user -> name . '!')
                    ->line('Te damos la bienvenida a nuestro sistema de cursos online.')
                    ->line('Se ha creado una cuenta para ti para que puedas acceder a toda la información.')
                    ->line('Tus datos de acceso son:')
                    ->line('Usuario: **' . $this -> user -> email . '** / Contraseña: **' . $this -> password . '**')
                    ->action('Acceder ahora', route('login'))
                    ->line('¡Gracias por ser parte!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
