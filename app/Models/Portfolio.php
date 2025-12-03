<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
    ];
    protected $table = 'portfolios';

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
