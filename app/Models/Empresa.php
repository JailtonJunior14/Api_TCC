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

    protected $fillable = ['user_id','razao_social','telefone', 'foto', 'cnpj','id_ramo','localidade', 'uf', 'estado', 'cep', 'rua', 'numero', 'infoadd'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
