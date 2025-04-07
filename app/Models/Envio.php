<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Envio extends Model
{
    protected $fillable = [
        'cliente_id',
        'destinatario',
        'estado',
        'bultos',
        'kilos',
        'informacion'
    ];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function reparto(): BelongsTo
    {
        return $this->belongsTo(Reparto::class, 'reparto_id');
    }
}
