<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CajaResource extends JsonResource
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
            'user' => $this->usuario->name,
            'fecha_apertura' => $this->fecha_apertura,
            'fecha_cierre' => $this->fecha_cierre,
            'monto_apertura' => $this->monto_apertura,
            'monto_cierre' => $this->monto_cierre,
            'estado_caja' => $this->estado->name,
            'observaciones' => $this->observaciones
        ];
    }
}
