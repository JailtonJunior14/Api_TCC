<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $table = 'skills';

    protected $fillable = ['nome', 'id_ramo'];

    public $timestamps = false;

    public function ramos(){
        return $this->belongsTo(Ramo::class);
    }

    public function prestador()
    {
        return $this->belongsToMany(Prestador::class);
    }

}
