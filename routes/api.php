<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\TelefoneController;
use App\Models\Contratante;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
});


Route::resource('cidades', CidadeController::class);
//rotas contratante
Route::get('/contratante', [ContratanteController::class, 'index']);
Route::post('/contratante/cadastro', [ContratanteController::class, 'store']);
Route::get('/contratante/listar/{id}', [ContratanteController::class, 'show']);
Route::patch('/contratante/atualizar/{id}', [ContratanteController::class, 'update']);
Route::delete('/contratante/deletar/{id}', [ContratanteController::class, 'destroy']);

// Route::apiResource('contratante', ContratanteController::class);


//rotas ramo


//rotas prestador


//rotas empresa

//rotas links

//rotas portfolio

//rotas telefone

Route::get('/telefone/listar_todos', [TelefoneController::class, 'index']);
Route::post('/telefone/cadastro', [TelefoneController::class, 'store']);


//rotas País, Estado, Cidade

Route::get('/pais/listar', [PaisController::class, 'index']);
Route::get('/estado/listar', [EstadoController::class, 'index']);
Route::get('/cidade/listar', [CidadeController::class, 'index']);