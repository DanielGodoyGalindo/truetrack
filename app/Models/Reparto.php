<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reparto extends Model
{
    protected $fillable = [
        'gestor_id',
        'transportista_id',
        'vehiculo_id',
        'estado',
    ];

    // Relacion inversa con usuario gestor (1:N)
    public function gestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_id');
    }

    // Relación inversa con usuario transportista (1:N)
    public function transportista(): BelongsTo
    {
        return $this->belongsTo(User::class, 'transportista_id');
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
