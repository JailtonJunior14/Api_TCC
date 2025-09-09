<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestador';
    public $timestamps = false;
    protected $fillable = ['user_id','nome','cpf','whatsapp','fixo', 'foto', 'cep', 'id_ramo', 'localidade', 'uf', 'estado', 'cep','numero', 'rua'];


    function comentarioRecebido(){
        return $this->hasMany(Comentario::class, 'id_prestator_destino');
    }

    function portfolio(){
        return $this->hasMany(Portfolio::class, 'id_prestador');
    }

    public function user() {
        return $this->belongsTo(Users::class);
    }
}
