<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['nome', 'email', 'senha', 'foto'];

    function telefone()
    {
        return $this->belongsTo(Telefone::class);
    }
}
