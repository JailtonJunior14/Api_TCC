<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CidadeController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ContratanteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PrestadorController;
use App\Http\Controllers\RamoController;
use App\Http\Controllers\TelefoneController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ValidationController;
use App\Models\Contratante;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
});

//requisições 
Route::get('/check-email', [ValidationController::class, 'check_email']);
Route::get('/check_cpf_contratante', [ValidationController::class, 'check_cpf_contratante']);
Route::get('/check_cpf_prestador', [ValidationController::class, 'check_cpf_prestador']);
Route::get('/check_cnpj', [ValidationController::class, 'check_cnpj']);
Route::get('/check_numero', [ValidationController::class, 'check_numero']);
Route::get('/check_razaosocial', [ValidationController::class, 'check_razaoSocial']);

Route::post('/telefone', [TelefoneController::class, 'store']);




Route::get('/forgot-password', [PasswordController::class, 'forgot_password']);
Route::get('/verificar-codigo', [PasswordController::class, 'verificar_code']);
Route::get('/atualizar-senha', [PasswordController::class, 'atualizar_senha']);

Route::post('/usuario/cadastro', [UsersController::class, 'store']);
Route::post('/usuario/update', [UsersController::class, 'update']);
Route::post('/usuario-teste', [UsersController::class, 'select']);


// //rotas contratante
// Route::get('/contratante', [ContratanteController::class, 'index']);
// Route::post('/contratante/cadastro', [ContratanteController::class, 'store']);
// Route::get('/contratante/listar/{id}', [ContratanteController::class, 'show']);
// Route::patch('/contratante/atualizar/{id}', [ContratanteController::class, 'update']);
// Route::delete('/contratante/deletar/{id}', [ContratanteController::class, 'destroy']);

// Route::apiResource('contratante', ContratanteController::class);


//rotas ramo
Route::get('/ramo', [RamoController::class, 'index']);
Route::get('/ramo/{modalidade}', [RamoController::class, 'show']);
Route::get('/ramo/nome/{nome}', [RamoController::class, 'nome']);

// //rotas prestador
// Route::get('/prestador', [PrestadorController::class, 'index']);
// Route::post('/prestador/cadastro', [PrestadorController::class, 'store']);
// Route::get('/prestador/listar/{id}', [PrestadorController::class, 'show']);
// Route::patch('/prestador/atualizar/{id}', [PrestadorController::class, 'update']);
// Route::delete('/prestador/deletar/{id}', [PrestadorController::class, 'destroy']);

// //rotas empresa
// Route::get('/empresa', [EmpresaController::class, 'index']);
// Route::post('/empresa/cadastro', [EmpresaController::class, 'store']);
// Route::get('/empresa/listar/{id}', [EmpresaController::class, 'show']);
// Route::patch('/empresa/atualizar/{id}', [EmpresaController::class, 'update']);
// Route::delete('/empresa/deletar/{id}', [EmpresaController::class, 'destroy']);
//rotas links

Route::get('/link', [LinksController::class, 'index']);
Route::post('/link/cadastro', [LinksController::class, 'store']);
//rotas portfolio

//rotas comentario




//rotas País, Estado, Cidade


//rotas login

Route::post('/login', [LoginController::class, 'login']);



Route::middleware(['auth:prestador'])->get('/perfil', function(){
    return response()->json([
        'message' => 'to logado'
    ]);
});

