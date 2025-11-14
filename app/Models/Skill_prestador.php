<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill_prestador extends Model
{
    use HasFactory;

    protected $table = 'skill_prestador';

    protected $fillable = ['prestador_id', 'skill_id'];

    public $timestamps = false;
}
