<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
});


Route::resource('cidades', CidadeController::class);

Route::get('/cidades/estado/{estadoId}', [CidadeController::class, 'listarporEstado']);
