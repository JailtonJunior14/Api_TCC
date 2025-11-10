<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public $timestamps = false;

    public $fillable = ['email', 'password', 'type'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function empresa()
    {
        return $this->hasOne(Empresa::class, 'user_id');
    }

    public function prestador()
    {
        return $this->hasOne(Prestador::class, 'user_id');
    }

    public function contratante()
    {
        return $this->hasOne(Contratante::class, 'user_id');
    }

    public function contato()
    {
        return $this->hasOne(Contato::class);
    }

    public function portfolios()
    {
        return $this->hasOne(Portfolio::class, 'user_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany(Avaliacao::class, 'user_id');
    }
}
