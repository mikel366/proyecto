<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function producto():BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
