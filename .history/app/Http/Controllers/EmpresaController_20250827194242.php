<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresa = Empresa::all();

        return $empresa;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validacao = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|unique:empresa,email',
                'password' => 'required|string|confirmed',
                'whatsapp' => 'string|max:18|unique:empresa,whatsapp',
                'fixo' => 'string|max:18|unique:empresa,fixo',
                'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'cnpj' => 'required|string',
                'cep' => 'required|string',
                'id_cidade' => 'required|integer|exists:cidade,id',
                'id_ramo' => 'required|integer|exists:ramo,id'
            ]);

            $imagem_path = $request->file('foto')->store('fotos', 'public');
            $empresa = new Empresa();

            $empresa->nome = $validacao['nome'];
            $empresa->email = $validacao['email'];
            $empresa->password = Hash::make($validacao['password']);
            $empresa->whatsapp = $validacao['whatsapp'];
            $empresa->fixo = $validacao['fixo'];
            $empresa->foto = $validacao['foto'];
            $empresa->cnpj = $validacao['cnpj'];
            $empresa->cep = $validacao['cep'];
            $empresa->id_cidade = $validacao['id_cidade'];
            $empresa->id_ramo = $validacao['id_ramo'];
            $empresa->foto = $imagem_path;

            $empresa->save();


            $token = auth('empresa')->attemp([
                'email' => $validacao['email'],
                'password' => $validacao['password']
            ]);

            $logado = auth('empresa')->user();



            return response()->json([
                'token' => $token,
                'empresa' => $logado
            ],201);




        } catch (QueryException $e) {
            Log::error('Erro ao cadastrar no banco', ['error', $e->getMessage()]);

            return response()->json([
                'error' => 'Erro ao cadstrar no banco'

            ],500);
        } catch (Exception $e){
            Log::error('Erro inesperado' , ['error', $e->getMessage()]);

            return response()->json([
                'error' => 'erro inesperado'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $empresa = Empresa::find($id);
            if(!$empresa){
                return response()->json([
                    'error' => 'Usuario não encontrado'
                ],404);
            }
            return response()->json($empresa);
        } catch (Exception $e) {
            Log::error('erro ao pesquisar', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Erro ao buscar'
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nome' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|unique:empresa,email,' .$id,
                'senha' => 'sometimes|string|confirmed',
                'whatsapp' => 'string|max:18|unique:empresa,whatsapp,' .$id,
                'fixo' => 'string|max:18|unique:empresa,fixo,' .$id,
                'foto' => 'sometimes|string',
                'cnpj' => 'sometimes|string',
                'cep' => 'sometimes|string',
                'id_cidade' => 'sometimes|integer|exists:cidade,id',
                'id_ramo' => 'sometimes|integer|exists:ramo,id'

            ]);

            $empresa = Empresa::findorfail($id);

            if($request->has('nome')){
                $empresa->nome = $request['nome'];
            }
            if($request->has('email')){
                $empresa->email = $request['email'];
            }
            if($request->has('senha')){
                $empresa->senha = Hash::make($request['senha']);
            }
            if($request->has('whatsapp')){
                $empresa->whatsapp = $request['whatsapp'];
            }
            if($request->has('fixo')){
                $empresa->fixo = $request['fixo'];
            }
            if($request->has('foto')){
                $empresa->foto = $request['foto'];
            }
            if($request->has('cnpj')){
                $empresa->cnpj= $request['cnpj'];
            }
            
            if($request->has('cep')){
                $empresa->cep = $request['cep'];
            }


            $empresa->save();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar',  ['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $empresa = Empresa::findorfail($id);

            if($empresa){
                $empresa->delete();
                return response()->json([
                    'Message' => 'conta deletada'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('erro ao tentar excluir a conta', ['error'=> $e->getMessage()]);

            return response()->json([
                'message' => 'erro ao deletar'
            ],500);
        }
            

    }
}
