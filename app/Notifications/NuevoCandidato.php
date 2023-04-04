<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoCandidato extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private $id_vacante, private $nombre_vacante, private $usuario_id)
    {
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url= url('/notificaciones');
        return (new MailMessage)
                    ->greeting('Hola')
                    ->subject('Nuevo candidato en '.$this->nombre_vacante)
                    ->line('Hay un nuevo candadito')
                    ->line('La vacante es: '.$this->nombre_vacante)
                    ->action('Ver notificaciones', $url)
                    ->salutation('Gracias por utilizar Devjobs');
    }

    //almacena las notificaciones en la BD
    public function toDataBase($notifiable)
    {
        return [
            'id_vacante'=>$this->id_vacante,
            'nombre_vacante'=>$this->nombre_vacante,
            'usuario_id'=>$this->usuario_id
        ];
    }
}
