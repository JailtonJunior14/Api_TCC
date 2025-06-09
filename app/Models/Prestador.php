<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Prestador extends Model implements JWTSubject
{
    use HasFactory;

    protected $table = 'prestador';
    public $timestamps = false;
    protected $fillable = ['nome', 'email', 'senha','whatsapp','fixo', 'foto', 'cep', 'id_cidade', 'id_ramo'];


    function comentarioRecebido(){
        return $this->hasMany(Comentario::class, 'id_prestator_destino');
    }

    function portfolio(){
        return $this->hasMany(Portfolio::class, 'id_prestador');
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
