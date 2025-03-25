<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación de usuario (cliente) con envios 1:N
    public function envios(): HasMany
    {
        return $this->hasMany(Envio::class, 'cliente_id');
    }

    // Relacion de usuario (gestor de trafico) con repartos 1:N
    public function repartosGestionados(): HasMany
    {
        return $this->hasMany(Reparto::class, 'gestor_id');
    }

    // relacion de usuario (transportista) con repartos 1:N
    public function repartosEnReparto(): HasMany
    {
        return $this->hasMany(Reparto::class, 'transportista_id');
    }

}
