<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\PrestadorController;
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
Route::get('/prestador', [PrestadorController::class, 'index']);
Route::post('/prestador/cadastro', [PrestadorController::class, 'store']);
Route::get('/prestador/listar/{id}', [PrestadorController::class, 'show']);
Route::patch('/prestador/atualizar/{id}', [PrestadorController::class, 'update']);
Route::delete('/prestador/deletar/{id}', [PrestadorController::class, 'destroy']);

//rotas empresa
Route::get('/empresa', [EmpresaController::class, 'index']);
Route::post('/empresa/cadastro', [EmpresaController::class, 'store']);
Route::get('/empresa/listar/{id}', [EmpresaController::class, 'show']);
Route::patch('/empresa/atualizar/{id}', [EmpresaController::class, 'update']);
Route::delete('/empresa/deletar/{id}', [EmpresaController::class, 'destroy']);
//rotas links

//rotas portfolio


//rotas País, Estado, Cidade

Route::get('/pais', [PaisController::class, 'index']);
Route::get('/estado/listar/{id}', [EstadoController::class, 'show']);
Route::get('/estado', [EstadoController::class, 'index']);
Route::get('/cidade', [CidadeController::class, 'index']);

//rotas login

Route::post('/login', [LoginController::class, 'logar']);