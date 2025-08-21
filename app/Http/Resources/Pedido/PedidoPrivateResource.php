<?php

namespace App\Http\Resources\Pedido;

use App\Http\Resources\DetallePedido\DetallePedidoPrivateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoPrivateResource extends JsonResource
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
            'usuario' => $this->usuario,
            'locacion' => $this->locacion,
            'canalVenta' => $this->canalVenta,
            'caja' => $this->caja,
            'estado_pedido' => $this->estadoPedido->name,
            'total' => $this->total,
            'detalles' => DetallePedidoPrivateResource::collection($this->detalles)
            // 'detalles' => $this->detalles()->get(),
        ];
    }
}
