<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CertificacionEvaluada extends Notification
{
    protected $certificacion;

    public function __construct($certificacion)
    {
        $this->certificacion = $certificacion;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // 🔥 ambos canales
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Resultado de su certificación')
            ->greeting('Estimado/a '.$notifiable->name)
            ->line('Su solicitud ha sido evaluada.')
            ->line('Estado: '.$this->certificacion->estado)
            ->action('Ver certificación', url('/certificaciones/'.$this->certificacion->id))
            ->line('Gracias por confiar en nuestra institución.');
    }

    public function toArray($notifiable)
    {
        return [
            'certificacion_id' => $this->certificacion->id,
            'estado' => $this->certificacion->estado,
            'mensaje' => 'Su certificación fue evaluada'
        ];
    }
}