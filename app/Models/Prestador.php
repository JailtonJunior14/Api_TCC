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


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ramo()
    {
        return $this->belongsTo(Ramo::class, 'id_ramo');
    }
}
