<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caja extends Model
{
    protected $fillable = [
        'user_id',
        'fecha_apertura',
        'fecha_cierre',
        'monto_apertura',
        'monto_cierre',
        'estado_caja_id',
        'observaciones',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    //relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoCaja::class, 'estado_caja_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class);
    }
    
}
