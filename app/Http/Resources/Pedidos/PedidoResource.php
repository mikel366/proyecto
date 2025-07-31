<?php

namespace App\Http\Resources\Pedidos;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'total' => $this->total,
        'user' => $this->usuario,
        'locacion' => $this->locacion,
        'canal_venta' => $this->canalVenta,
        'metodo_pago' => $this->metodoPago,
        'caja' => $this->caja,
        'estado' => $this->estadoPedido,
        'detalles' => $this->whenLoaded('detalles', function() {
            return $this->detalles->map(function($detalle) {
                return [
                    'id' => $detalle->id,
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->precio_unitario,
                    'subtotal' => $detalle->subtotal,
                    'producto' => $detalle->producto
                ];
            });
        })
    ];
}
}
