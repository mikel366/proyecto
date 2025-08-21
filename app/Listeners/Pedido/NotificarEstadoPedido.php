<?php

namespace App\Listeners\Pedido;

use App\Events\Pedido\EstadoPedidoActualizado;
use App\Models\User;
use App\Notifications\Pedido\EstadoPedidoActualizadoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificarEstadoPedido
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EstadoPedidoActualizado $event): void
    {
        $pedido = $event->pedido;

        // Notificar al cliente
        $pedido->user->notify(new EstadoPedidoActualizadoNotification($pedido));

        // Notificar a los administradores también
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new EstadoPedidoActualizadoNotification($pedido));
        }
    }
}
