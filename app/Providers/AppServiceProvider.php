<?php

namespace App\Providers;

use App\Events\Pedido\EstadoPedidoActualizado;
use App\Events\Pedido\PedidoCreado;
use App\Listeners\Pedido\NotificarEstadoPedido;
use App\Listeners\Pedido\NotificarPedidoCreado;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(PedidoCreado::class, NotificarPedidoCreado::class);
        Event::listen(EstadoPedidoActualizado::class, NotificarEstadoPedido::class);
    }
}
