<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function locacion(): BelongsTo
    {
        return $this->belongsTo(Locacion::class);
    }

    public function canalVenta(): BelongsTo
    {
        return $this->belongsTo(CanalVenta::class);
    }
    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }
    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }
    public function detalles():HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }
    public function estadoPedido():BelongsTo
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_id');
    }
}
