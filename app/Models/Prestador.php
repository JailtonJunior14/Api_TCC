<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestador';

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'nome', 'cpf', 'whatsapp', 'fixo', 'foto', 'descricao',
        'cep', 'id_ramo', 'localidade', 'uf', 'estado', 'cep', 'numero', 'rua',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ramo()
    {
        return $this->belongsTo(Ramo::class, 'id_ramo');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
