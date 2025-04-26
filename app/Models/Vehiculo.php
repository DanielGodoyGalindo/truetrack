<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehiculo extends Model
{
    protected $fillable = [
        'matricula',
        'carga_max',
    ];

    // relación 1:N entre vehículo y reparto (un vehiculo puede tener varios repartos)
    public function repartos(): HasMany
    {
        return $this->hasMany(Reparto::class, 'vehiculo_id');
    }
}
