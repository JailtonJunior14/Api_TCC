<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    public $timestamps = false;

    protected $fillable = ['user_id','razao_social','whatsapp','fixo', 'foto', 'cnpj','id_ramo','localidade', 'uf', 'estado', 'cep', 'rua', 'numero'];
    
    function comentarioRecebido(){
        return $this->hasMany(Comentario::class, 'id_empresa_destino');
    }

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_empresa_autor');
    }

    function portfolio(){
        return $this->hasMany(Prestador::class, 'id_empresa');
    }


    public function user() {
        return $this->belongsTo(Users::class);
    }
}
