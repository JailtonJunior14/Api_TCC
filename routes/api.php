<?php

use App\Http\Controllers\AvaliacaoController;
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
use App\Http\Controllers\PortfolioController;
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
Route::get('/check-cpf_contratante', [ValidationController::class, 'check_cpf_contratante']);
Route::get('/check-cpf', [ValidationController::class, 'check_cpf']);
Route::get('/check-cnpj', [ValidationController::class, 'check_cnpj']);
Route::get('/check-numero', [ValidationController::class, 'check_numero']);
Route::get('/check-razaosocial', [ValidationController::class, 'check_razaoSocial']);

Route::post('/telefone', [TelefoneController::class, 'store']);




Route::get('/forgot-password', [PasswordController::class, 'forgot_password']);
Route::get('/verificar-codigo', [PasswordController::class, 'verificar_code']);
Route::get('/atualizar-senha', [PasswordController::class, 'atualizar_senha']);

Route::post('/usuario/cadastro', [UsersController::class, 'store']);
Route::post('/usuario/update', [UsersController::class, 'update']);
Route::post('/usuario-teste', [UsersController::class, 'select']);



//rotas ramo
Route::get('/ramo', [RamoController::class, 'index']);
Route::get('/ramo/{modalidade}', [RamoController::class, 'show']);
Route::get('/ramo/nome/{nome}', [RamoController::class, 'nome']);
//rotas links

Route::get('/link', [LinksController::class, 'index']);
Route::post('/link/cadastro', [LinksController::class, 'store']);
//rotas portfolio
Route::get('/portfolio', [PortfolioController::class, 'show']);
Route::get('/portfolio/{id}', [PortfolioController::class, 'selectId']);
Route::post('/portfolio/cadastro', [PortfolioController::class, 'store']);
Route::post('/portfolio/user', [PortfolioController::class, 'select']);
Route::get('/portfolio/user/{id}', [PortfolioController::class, 'selectIdUser']);

//rotas avaliação
Route::post('/avaliar', [AvaliacaoController::class, 'store']);
Route::get('/avaliacao', [AvaliacaoController::class, 'show']);

//rota que para fazer os cars funcionarios(ariane)
Route::get('/usuarios', [UsersController::class, 'index']);
//

//rotas País, Estado, Cidade


//rotas login

Route::post('/login', [LoginController::class, 'login']);



Route::middleware(['auth:user'])->get('/perfil', function(){
    return response()->json([
        'message' => 'to logado'
    ]);
});

