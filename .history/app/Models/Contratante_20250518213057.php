<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
    use HasFactory;
    protected $table = 'contratante';

    public $timestamps = false;

    public $fillable = ['nome', 'email', 'senha', 'id_cidade'];

    public function telefones(){

        return $this->morphMany(Telefone::class, 'telefoneable');
    }
}
