<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'pais';
    protected $fillable = ['nome'];

    public $timestamps = false;

    public function estados()
    {
        return $this->hasMany(Estado::class);
    }
}
