<?php

namespace App\Http\Resources\Pedido;

use App\Http\Resources\DetallePedido\DetallePedidoPublicResource;
use App\Http\Resources\DetallePedidoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoPublicResource extends JsonResource
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
            'estado' => $this->estadoPedido->name,
            'detalles' => DetallePedidoPublicResource::collection($this->detalles),
        ];
    }
}
