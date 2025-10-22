<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    public function telefone() {
        return $this->hasOne(Telefone::class);
    }

    function portfolios(){
        return $this->hasOne(Portfolio::class, 'user_id');
    }

    function avaliacoes(){
        return $this->hasMany(Avaliacao::class, 'user_id');
    }
}
