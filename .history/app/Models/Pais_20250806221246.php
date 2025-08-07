<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    Use HasFactory;

    protected $table = 'countries';
    protected $fillable = ['country_name', '','',''];

    public $timestamps = false;

    public function estados()
    {
        return $this->hasMany(Estado::class);
    }
}
