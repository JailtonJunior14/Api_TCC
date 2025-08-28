<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contratante extends Authenticatable implements JWTSubject
{
    use HasFactory, N;
    protected $table = 'contratante';

    public $timestamps = false;

    public $fillable = ['nome', 'email', 'password', 'id_cidade', 'foto'];

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_contratante_autor');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}

