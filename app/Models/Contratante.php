<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
    use HasFactory;
    protected $table = 'contratante';

    public $timestamps = false;

    public $fillable = ['nome', 'email', 'senha', 'id_cidade', 'foto'];

    function comentarioFeito(){
        return $this->hasMany(Comentario::class, 'id_contratante_autor');
    }

}

