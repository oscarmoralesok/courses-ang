<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuscribeNotification extends Notification
{
    use Queueable;

    public $user, $course;

    public function __construct($user, $course)
    {
        $this -> user = $user;
        $this -> course = $course;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Inscripción a ' . $this -> course -> name)
                    ->greeting('¡Hola ' . $this -> user -> name . '!')
                    ->line('Muchas gracias por comprar nuestro curso **' . $this -> course -> name . '** .')
                    ->line('Ya puedes acceder y empezar a disfrutar del contenido del curso.')
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
