<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estado extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'estado';
    protected $filltable = ['nome', 'sigla'];

    public function cidades()
    {
        return $this->hasMany(Cidade::class);
    }
}
