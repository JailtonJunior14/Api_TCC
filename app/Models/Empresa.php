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


    
}
