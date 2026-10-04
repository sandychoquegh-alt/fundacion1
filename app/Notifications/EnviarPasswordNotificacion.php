<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarPasswordNotificacion extends Notification
{
    use Queueable;

    public $passwordPlano;

    public function __construct($passwordPlano)
    {
        $this->passwordPlano = $passwordPlano;
    }

    public function via($notifiable)
    {
        return ['mail']; // Se enviará por correo
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tu acceso al sistema')
            ->greeting('¡Hola ' . $notifiable->name . '!')
            ->line('Tu cuenta fue creada correctamente.')
            ->line('Tu contraseña es:')
            ->line('**' . $this->passwordPlano . '**')
            ->line('Puedes ingresar al sistema usando tu correo y esta contraseña.')
            ->line('Por seguridad, cambia tu contraseña después de iniciar sesión.');
    }
}
