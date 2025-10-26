<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ramo extends Model
{
    use HasFactory;

    protected $table = 'ramo';
    protected $fillable = ['nome', 'id_categoria'];

    public $timestamps = false;

    function categorias(){
        return $this->belongsTo(Categoria::class);
    }
}
