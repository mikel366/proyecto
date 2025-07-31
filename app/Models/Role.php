<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $guarded = []; // Campos asignables en masa

    protected $hidden = ['created_at', 'updated_at'];

    // Relación: Un Role tiene muchos Users
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
