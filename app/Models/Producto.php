<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenProducto::class);
    }
    
    public function detalleProducto(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }
}
