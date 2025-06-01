<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'imagem', 'id_empresa', 'id_prestador'];
    protected $table = 'portfolio';

    function autorEmpresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    function autorPrestador(){
        return $this->belongsTo(Prestador::class, 'id_prestador');
    }
}
