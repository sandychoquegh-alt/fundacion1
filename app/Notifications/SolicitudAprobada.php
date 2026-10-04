<?php

namespace App\Notifications;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SolicitudAprobada extends Notification implements ShouldQueue
{
    use Queueable;

    protected $table = 'notificaciones'; // tu tabla personalizada
    protected $fillable = ['usuario_id', 'mensaje', 'leido', 'fecha'];

    public $timestamps = false; // si no usas created_at / updated_at

    protected $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    // Canales: mail + base de datos
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Contenido del email
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Solicitud Aprobada')
                    ->greeting('Hola '.$notifiable->nombre)
                    ->line('Tu solicitud para el producto "'.$this->solicitud->producto_nombre.'" ha sido aprobada.')
                    ->line('Ahora puedes verificar los detalles de tu solicitud en el sistema.')
                    ->action('Ver Solicitud', url('/empresa/solicitudes'))
                    ->line('Gracias por usar nuestro sistema.');
    }

    // Contenido para base de datos
    public function toDatabase($notifiable)
    {
        return [
            'solicitud_id' => $this->solicitud->id,
            'producto' => $this->solicitud->producto_nombre,
            'mensaje' => 'Tu solicitud ha sido aprobada.'
        ];
    }
}
