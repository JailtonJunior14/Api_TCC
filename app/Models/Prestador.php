<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestador';
    public $timestamps = false;
    protected $fillable = ['nome', 'email', 'senha', 'foto', 'cep', 'id_cidade', 'id_ramo'];
}
