<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use App\Models\Empresa;
use App\Models\Prestador;
use App\Models\Telefone;
use App\Models\Users;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
       try{ $request->validate([
            /*
                    'localidade' => 'required|string|max:255',
                    'uf' => 'string|max:2',
                    'estado' => 'required|string|max:255',
                    'cep' => 'required|string|max:10',
                    'rua' => 'required|string|max:255',
                    'numero' => 'required|string|max:255',
                    'infoadd' => 'required|string|max:255'
            */
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:empresa,prestador,contratante',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'telefone' => 'required|string',
            'localidade' => 'required|string|max:255',
            'uf' => 'string|max:2',
            'estado' => 'required|string|max:255',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'infoadd' => 'required|string|max:255',



            // dados específicos (validação condicional)
            'cnpj' => 'required_if:type,empresa',
            'razao_social' => 'required_if:type,empresa',
            'id_ramo' => 'required_if:type,empresa,prestador|integer|exists:ramo,id',

            'cpf' => 'required_if:type,prestador,contratante',
            // 'profissao' => 'required_if:type,prestador,empresa',
            //'endereco' => 'required_if:type,contratante,prestador',
            'nome' => 'required_if:type,contratante,prestador',
        ]);


        $imagem_path = $request->hasFile('foto')
    ? $request->file('foto')->store('fotos', 'public')
    : null;

$user = new Users();
$user->email = $request['email'];
$user->password = Hash::make($request['password']);
$user->type = $request['type'];
$user->save();

$telefone = new Telefone();
$telefone->user_id = $user->id;
$telefone->telefone = $request->telefone;
$telefone->save();

switch ($request->type) {
    case 'empresa':
        $empresa = new Empresa();
        $empresa->user_id = $user->id;
        $empresa->cnpj = $request->cnpj;
        $empresa->razao_social = $request->razao_social;
        $empresa->id_ramo = $request->id_ramo;
        $empresa->foto = $imagem_path;
        $empresa->localidade = $request->localidade;
        $empresa->uf = $request->uf;
        $empresa->estado = $request->estado;
        $empresa->cep = $request->cep;
        $empresa->rua = $request->rua;
        $empresa->numero = $request->numero;
        // $empresa->infoadd = $request->infoadd;

        $empresa->save();
        break;

    case 'prestador':
        $prestador = new Prestador();
        $prestador->user_id = $user->id;
        $prestador->nome = $request->nome;
        $prestador->cpf = $request->cpf;
        $prestador->id_ramo = $request->id_ramo;
        $prestador->foto = $imagem_path;
        $prestador->localidade = $request->localidade;
        $prestador->uf = $request->uf;
        $prestador->estado = $request->estado;
        $prestador->cep = $request->cep;
        $prestador->rua = $request->rua;
        $prestador->numero = $request->numero;
        // $prestador->infoadd = $request->infoadd;

        $prestador->save();
        break;

    case 'contratante':
        $contratante = new Contratante();
        $contratante->user_id = $user->id;
        $contratante->nome = $request->nome;
        $contratante->cpf = $request->cpf;
        $contratante->foto = $imagem_path;
        $contratante->localidade = $request->localidade;
        $contratante->uf = $request->uf;
        $contratante->estado = $request->estado;
        $contratante->cep = $request->cep;
        $contratante->rua = $request->rua;
        $contratante->numero = $request->numero;
        $contratante->infoadd = $request->infoadd;
        $contratante->save();
        break;
}

$token = auth('user')->attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ]);

            if(!$token){
                return response()->json([
                    'error' => 'token não ta sendo gerado'
                ]);
            }

            $logado = auth('user')->user();

return response()->json([
    'message' => 'Usuário cadastrado com sucesso!',
    'user' => $user->load($user->type),
    'token' => $token,
    'logado' => $logado
], 201);

    }
    catch (ValidationException $e) {
    Log::error('Validation error', ['message' => $e->getMessage()]);
    return response()->json([
        'error' => 'Erro de validação',
        'details' => $e->errors(),
    ], 422);
} catch (QueryException $e) {
    Log::error('Database error', ['message' => $e->getMessage()]);
    return response()->json([
        'error' => 'Erro no banco de dados',
        'details' => $e->getMessage(),
    ], 500);
} catch (Exception $e) {
    Log::error('General error', ['message' => $e->getMessage()]);
    return response()->json([
        'error' => 'Erro inesperado',
        'details' => $e->getMessage(),
    ], 500);
}

    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        //
    }
}
