<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ContratanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contratantes = Contratante::all();
        //seria isso:
        // $contratante = new Contratante();
        // $contratantes = $contratante->all();

         return $contratantes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'nome' => 'required|string|max:255',
                    'email' => 'required|email|unique:contratante,email',
                    'password' => 'required|string|confirmed',
                    'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                    'localidade' => 'required|string|max:255',
                    'uf' => 'required|string|max:2',
                    'estado' => 'required|string|max:255',
                    'cep' => 'required|string|max:10',
                    'rua' => 'required|string|max:255'
                ]
            );
            $imagem_path = $request->file('foto')->store('fotos', 'public');

            $contratante = new Contratante();
            $contratante->nome = $request['nome'];
            $contratante->email = $request['email'];
            $contratante->password = Hash::make($request['password']);
            $contratante->foto = $imagem_path;
            $contratante->localidade = $request['localidade'];
            $contratante->uf = $request['uf'];
            $contratante->estado = $request['estado'];
            $contratante->cep = $request['cep'];
            $contratante->rua = $request['rua'];

            $contratante->save();

            $token = auth('contratante')->attempt([
                'email' => $request['email'],
                'password' => $request['password']
            ]);

            if(!$token){
                return response()->json([
                    'error' => 'token não ta sendo gerado'
                ]);
            }

            $logado = auth('contratante')->user();

            return response()->json(
            [
                'token' => $token,
                'contratante' => $logado
            ], 201
            );
        } catch (QueryException $e) {
            // Erros específicos de banco de dados
            Log::error('Erro ao salvar usuário no banco de dados', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erro ao salvar no banco de dados.'
            ], 500);

        } catch (\Exception $e) {
            // Outros erros inesperados
            Log::error('Erro inesperado ao criar usuário', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erro inesperado. Tente novamente mais tarde.'
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $contratante= Contratante::find($id);
            if (!$contratante) 
            {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

            return response()->json($contratante);
        } catch(\Exception $e) {
            Log::error('erro ao buscar Contratante' , ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Error ao buscar Contratante'
            ], 500);
        } 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {

            $request->validate(
                [
                    'nome' => 'sometimes|string|max:255',
                    'email' => 'sometimes|email|unique:contratante,email,' . $id,
                    'senha' => 'sometimes|string|confirmed',
                    'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                    'localidade' => 'sometimes|string|max:255',
                    'uf' => 'sometimes|string|max:2',
                    'estado' => 'sometimes|string|max:255',
                    'cep' => 'sometimes|string|max:10',
                    'rua' => 'sometimes|string|max:255'
                ]
            );

            $contratante = Contratante::findorfail($id);

            if($request->has('nome'))
            {
                    $contratante->nome = $request['nome'];   
            }
            if($request->has('email'))
            {
                    $contratante->email = $request['email'];   
            }
            if($request->has('nome'))
            {
                    $contratante->senha = hash::make($request['senha']);   
            }
            if($request->hasFile('foto')){
                $foto_path = $request->file('foto')->store('fotos', 'public');
                $contratante->foto = $foto_path;
            }
            if($request->has('localidade'))
            {
                    $contratante->localidade = $request['localidade'];   
            }
            if($request->has('uf'))
            {
                    $contratante->uf = $request['uf'];   
            }
            if($request->has('estado'))
            {               
                    $contratante->estado = $request['estado'];   
            }
            if($request->has('cep'))
            {
                    $contratante->cep = $request['cep'];   
            }
            if($request->has('rua'))
            {
                    $contratante->rua = $request['rua'];   
            }

            $contratante->save();

        } catch(ValidationException $e){
            log::error('email ja cadastrado' , ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'email ja cadastrado'
            ], 422);
        } catch (\Exception $e) {
            Log::error('erro ao atualizar', ['erro' => $e->getMessage()]);

            return response()->json([
                'error' => 'erro ao atualizar'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $contratante = Contratante::find($id);

            if($contratante)
            {
                $contratante->delete();
                return response()->json('excluido com sucesso');
            } else {
                return response()->json('contratante nao existe ou ja foi excluido');
            }
        } catch (\Exception $e) {
            Log::error('erro ao excluir' , ['erro' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'Erro ao excluir'
            ],500);
        }
    }
}
