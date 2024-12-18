<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject; // Importe a interface JWTSubject
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject // Implemente a interface JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    /**
     * Obtenha o identificador único para o token JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Retorna o identificador único do usuário (geralmente o id)
    }

    /**
     * Obtenha os "claims" personalizados para o token JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];  // Aqui você pode adicionar qualquer dado adicional no payload do token (opcional)
    }
}
