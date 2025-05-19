<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['numero', 'telefoneable_id', 'telefoneable_type'];
    protected $table = 'telefone';

    function prestador()
    {
        return $this->morphTo();
    }

    function empresa()
    {
        return $this->morphTo();
    }
}
