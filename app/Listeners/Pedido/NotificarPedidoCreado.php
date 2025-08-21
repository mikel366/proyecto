<?php

namespace App\Listeners\Pedido;

use App\Events\Pedido\PedidoCreado;
use App\Models\User;
use App\Notifications\Pedido\PedidoCreadoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificarPedidoCreado
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
    public function handle(PedidoCreado $event): void
    {
        $pedido = $event->pedido;

        $pedido->usuario->notify(new PedidoCreadoNotification($event->pedido));

        // Notificar al administrador (puede ser un usuario con rol admin)
        $admins = User::where('role_id', '1')->get();
        foreach ($admins as $admin) {
            $admin->notify(new PedidoCreadoNotification($pedido));
        }
    }
}
