<?php

use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CurtidasController;
use App\Http\Controllers\Filtro;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\RamoController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\TelefoneController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return response()->json(['message' => 'Olá, Mundo']);
})->name('login');

// requisições
Route::prefix('/check')->group(function (){

    Route::get('/email', [ValidationController::class, 'check_email']);
    Route::get('/cpf', [ValidationController::class, 'check_cpf']);
    Route::get('/cnpj', [ValidationController::class, 'check_cnpj']);
    Route::get('/numero', [ValidationController::class, 'check_numero']);
    Route::get('/razaosocial', [ValidationController::class, 'check_razaoSocial']);
});

//rotas esqueceu a senha
Route::get('/forgot-password', [PasswordController::class, 'forgot_password']);
Route::get('/verificar-codigo', [PasswordController::class, 'verificar_code']);
Route::get('/atualizar-senha', [PasswordController::class, 'atualizar_senha']);

//rotas usuarios
Route::prefix('usuario')->group(function(){
    Route::post('/cadastro', [UsersController::class, 'store']);

    Route::middleware(['auth:user'])->group(function(){
        Route::post('/update', [UsersController::class, 'update']);
        Route::get('/{id}/posts', [UsersController::class, 'selectID']);
    });

    Route::get('/', [UsersController::class, 'index']);

    Route::post('/usuario-teste', [UsersController::class, 'select']);
});
Route::get('/usuarios/{id}', [UsersController::class, 'selectID']);

//curtidas perfil
Route::middleware(['auth:user'])->prefix('curtidas')->group(function (){
    Route::post('/auth',[CurtidasController::class, 'contarCurtidasAuth']);
    Route::post('/curtir/{id}',[CurtidasController::class, 'curtir']);
    Route::post('/descurtir/{id}',[CurtidasController::class, 'descurtir']);
    Route::post('/verificar/{id}',[CurtidasController::class, 'verificarCurtida']);
});


// rotas ramo, categoria e skills
Route::get('/ramo', [RamoController::class, 'index']);
Route::get('/categoria', [CategoriaController::class, 'index']);
Route::get('/ramo/nome/{nome}', [RamoController::class, 'nome']);
Route::get('/skills/{id}', [SkillController::class, 'index']);


// rotas portfolio
Route::middleware(['auth:user'])->prefix('portfolio')->group(function(){

    Route::get('/', [PortfolioController::class, 'show']);
    Route::get('/{id}', [PortfolioController::class, 'selectId']);
    Route::post('/cadastro', [PortfolioController::class, 'store']);
    Route::post('/update/{id}', [PortfolioController::class, 'update']);
    Route::post('/user', [PortfolioController::class, 'select']);
    // Route::get('/user/{id}', [PortfolioController::class, 'selectIdUser']);

});

// rotas avaliação
Route::middleware(['auth:user'])->group(function(){
    Route::post('/avaliar', [AvaliacaoController::class, 'store']);
    Route::get('/avaliacao', [AvaliacaoController::class, 'show']);
});

// rota que para fazer os cars funcionarios(ariane)
Route::get('/usuarios', [UsersController::class, 'index']);
//

// filtro
Route::get('/filtro', [FiltroController::class, 'filtro']);

// rotas login

Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:user'])->get('/perfil', function () {
    return response()->json([
        'message' => 'to logado',
    ]);
});
