<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;
    protected $table = 'telefone';

    public $timestamps = false;

    public $fillable = ['user_id','telefone'];


    public function user() {
        return $this->belongsTo(Users::class);
    }
}
