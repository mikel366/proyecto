<?php

namespace App\Http\Resources\DetallePedido;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetallePedidoPrivateResource extends JsonResource
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
            'pedido_id' => $this->pedido->id,
            'producto' => $this->producto->nombre,
            'cantidad' => $this->cantidad,
            'precio_unitario' => $this->producto->precio,
        ];
    }
}
