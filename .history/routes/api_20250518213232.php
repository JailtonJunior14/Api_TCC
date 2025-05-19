<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\TelefoneController;
use App\Models\Contratante;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
});


Route::resource('cidades', CidadeController::class);
//rotas contratante
Route::get('/contratante/listar_todos', [ContratanteController::class, 'index']);
Route::post('/contratante/cadastro', [ContratanteController::class, 'store']);
Route::get('/contratante/listar/{id}', [ContratanteController::class, 'show']);
Route::patch('/contratante/atualizar/{id}', [ContratanteController::class, 'update']);
Route::delete('/contratante/deletar/{id}', [ContratanteController::class, 'destroy']);


//rotas ramo


//rotas prestador


//rotas empresa

//rotas links

//rotas portfolio

//rotas telefone

Route::get('/telefone/listar_todos', [TelefoneController::class, 'index']);
Route::post('/telefone/cadastro', [TelefoneController::class, 'store']);