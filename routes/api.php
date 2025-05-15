<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ContratanteController;
use App\Models\Contratante;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
});


Route::resource('cidades', CidadeController::class);

Route::get('/contratante/cadastro', [ContratanteController::class, 'store']);
Route::get('/contratante/listar', [ContratanteController::class, 'show']);
Route::get('/contratante/listar_todos', [ContratanteController::class, 'index']);
