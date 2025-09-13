<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $fillable = 
        [
            'user_id', 'comentario', 'estrelas', 'id_alvo'
        ];
    protected $table = 'avaliacao';

    public $timestamps = true;


    
}
