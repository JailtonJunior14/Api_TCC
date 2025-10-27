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

    protected $fillable = [
        'user_id','razao_social','telefone', 'foto','descricao',
        'cnpj','id_categoria','localidade', 'uf',
        'estado', 'cep', 'rua', 'numero', 'infoadd'
    ];

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

    public function ramo()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}
