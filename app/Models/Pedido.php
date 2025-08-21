<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'locacion_id',
        'estado_id',
        'canal_venta_id',
        'caja_id',
        'metodo_pago_id',
        'total',
    ];

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
        return $this->belongsTo(Locacion::class, 'locacion_id');
    }

    public function canalVenta(): BelongsTo
    {
        return $this->belongsTo(CanalVenta::class, 'canal_venta_id');
    }
    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }
    public function detalles():HasMany
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }
    public function estadoPedido():BelongsTo
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_id');
    }
}
