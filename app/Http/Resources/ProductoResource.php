<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'name' => $this->nombre,
            'stock' => $this->stock,
            'price' => $this->precio,
            'code' => $this->codigo_barra,
            'images' => $this->imagenes->map(function ($imagen) {
                return asset($imagen->url);
            }),
        ];
    }
}
