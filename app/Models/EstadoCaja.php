<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCaja extends Model
{
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function cajas(): HasMany
    {
        return $this->hasMany(Caja::class);
    }
}
