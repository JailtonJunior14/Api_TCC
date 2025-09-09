<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contratante extends Model
{
    use HasFactory;
    protected $table = 'contratante';

    public $timestamps = false;

    public $fillable = ['user_id','nome', 'foto',
    'telefone','cpf','localidade', 
    'uf', 'estado', 'cep', 'rua','numero', 'infoadd'];

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_contratante_autor');
    }

    // public function getJWTIdentifier()
    // {
    //     return $this->getKey();
    // }

    // public function getJWTCustomClaims()
    // {
    //     return [];
    // }


    public function user() {
        return $this->belongsTo(Users::class);
    }

}

