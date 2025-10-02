<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'descricao'];
    protected $table = 'portfolios';

    function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

    function fotos() {
        return $this->hasMany(Foto::class);
    }
    function videos() {
        return $this->hasMany(Video::class);
    }
}
