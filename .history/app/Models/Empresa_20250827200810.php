<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empresa extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'empresa';

    public $timestamps = false;

    protected $fillable = ['nome',  'email', 'password','whatsapp','fixo', 'foto', 'cnpj', 'cep', 'id_cidade',  'id_ramo'];
    
    function comentarioRecebido(){
        return $this->hasMany(Comentario::class, 'id_empresa_destino');
    }

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_empresa_autor');
    }

    function portfolio(){
        return $this->hasMany(Prestador::class, 'id_empresa');
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
