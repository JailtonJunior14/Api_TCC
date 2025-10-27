<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    protected $table = 'categoria';

    public $timestamps = false;
    public $fillable = ['categoria'];

    function ramos(){
        return $this->hasMany(Ramo::class);
    }

    function empresas(){
        return $this->hasMany(Empresa::class);
    }
}
