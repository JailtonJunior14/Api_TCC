<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PrestadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
                $validacao = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|unique:prestador,email',
                'senha' => 'required|string|confirmed',
                'foto' => 'required|string',
                'cep' => 'required|integer|max:9',
                'id_cidade' => 'required|integer|exists:cidade,id',
                'id_ramo' => 'required|integer|exists:ramo,id'

                ]);

                $prestador = new Prestador();
                $prestador->nome = $validacao['nome'];
                $prestador->email = $validacao['email'];
                $prestador->senha = Hash::make($validacao['senha']);
                $prestador->foto = $validacao['foto'];
                $prestador->cep = $validacao['cep'];
                $prestador->id_cidade = $validacao['id_cidade'];
                $prestador->id_ramo = $validacao['id_ramo'];

                $prestador->save();

                return response()->json(
                    [
                        'message' => 'usuario cadastrado com sucesso',
                        'data' => $prestador
                    ], 201
                );
        }catch(QueryException $e){
            Log::error('Erro ao salvar no banco', ['error' => $e->getMessage()]);
            
            
            return response()->json([
                'error' => 'Erro ao salvar no banco de dados.'
            ], 500);

            ;
        }catch(Exception $e){
            Log::error('Erro', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $prestador = Prestador::find($id);

            if (!$prestador) {
                return response()->json([ 'error '=>'usuario não encontrado'], 404);
            }
        } catch (Exception $e) {
            Log::error('Erro ao buscar', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'error ao buscar'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestador $prestador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestador $prestador)
    {
        //
    }
}
