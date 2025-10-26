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

    protected $casts = [
        'disponivel' => 'boolean',
    ];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        return $this->disponivel ? 'Disponível' : 'Indisponível';
    }


    public function user() {
        return $this->belongsTo(User::class);
    }

}

