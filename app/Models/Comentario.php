<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = 
        [
            'descricao', 'id_prestador_destino',
            'id_empresa_autor', 'id_contratante_autor',
            'id_empresa_destino'
        ];
    protected $table = 'comentarios';

    public $timestamps = false;


    //Quem faz:

    function autorEmpresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa_autor');
    }
    function autorContratante() {
        return $this->belongsTo(Contratante::class, 'id_contratante_autor');
    }

    //Quem recebe:

    function destinoEmpresa(){
        return $this->belongsTo(Empresa::class, 'id_empresa_destino');
    }
    function destinoPrestador(){
        return $this->belongsTo(Prestador::class, 'id_prestador_destino');
    }
}
