<?php

public function toMail($notifiable)
{
    return (new MailMessage)
        ->subject('Visita Programada')
        ->line('Se ha programado una visita.')
        ->line('Fecha: ' . $this->visita->fecha_visita)
        ->action('Ver Panel', url('/empresa/dashboard'));
}