<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reparto extends Model
{
    // Relacion inversa con usuario (1:N)
    public function gestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    // Relación inversa con vehiculo (1:N)
    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    // Relación 1:N entre reparto y envio (un reparto tiene 1 o varios envios)
    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'reparto_id');
    }
}
