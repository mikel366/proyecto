<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocacionResources extends JsonResource
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
            'calle' => $this->calle,
            'numero' => $this->numero,
            'barrio' => $this->barrio,
            'referencia' => $this->referencia,
            'altitud' => $this->altitud,
            'longitud' => $this->longitud,
            'is_default' => $this->is_default
        ];
    }
}
