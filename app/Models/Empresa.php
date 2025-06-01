<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';

    public $timestamps = false;

    protected $fillable = ['nome',  'email', 'senha','whatsapp','fixo', 'foto', 'cnpj', 'cep', 'id_cidade',  'id_ramo'];
    
    function comentarioRecebido(){
        return $this->hasMany(Comentario::class, 'id_empresa_destino');
    }

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_empresa_autor');
    }

    function portfolio(){
        return $this->hasMany(Prestador::class, 'id_empresa');
    }
}
