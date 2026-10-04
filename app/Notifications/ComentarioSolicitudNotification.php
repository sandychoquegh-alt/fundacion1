<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ComentarioSolicitudNotification extends Notification
{
    use Queueable;

    protected $mensaje;
     protected $solicitud_id;  
  
    public function __construct($mensaje, $solicitud_id)
    {
        $this->mensaje = $mensaje;
        $this->solicitud_id = $solicitud_id;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => $this->mensaje,
            'solicitud_id' => $this->solicitud_id,
        ];
    }

    public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Nuevo comentario en tu solicitud')
        ->greeting('Hola ' . $notifiable->name)
        ->line('Tienes un nuevo comentario en tu solicitud.')
        ->line($this->mensaje)
        ->action('Ver solicitud', url('/empresa/solicitud/' . $this->solicitud_id))
        ->line('Gracias por usar nuestro sistema.');
}
}