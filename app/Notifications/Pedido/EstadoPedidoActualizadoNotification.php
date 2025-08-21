<?php

namespace App\Notifications\Pedido;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstadoPedidoActualizadoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected Pedido $pedido;
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }
    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'titulo' => 'Estado del pedido actualizado',
            'mensaje' => "El pedido con ID {$this->pedido->id} ha sido actualizado al estado: {$this->pedido->estado->nombre}.",
            'pedido_id' => $this->pedido->id,
            'estado' => $this->pedido->estado->nombre,
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
