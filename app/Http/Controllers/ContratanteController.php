<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            $validacao = $request->validate(
                [
                    'nome' => 'required|string|max:255',
                    'email' => 'required|email|unique:contratante,email',
                    'senha' => 'required|string|confirmed',
                    'id_cidade' => 'required|integer|exists:cidade,id',
                ]
            );

            $contratante = new Contratante();
            $contratante->nome = $validacao['nome'];
            $contratante->email = $validacao['email'];
            $contratante->senha = Hash::make($validacao['senha']);
            $contratante->id_cidade = $validacao['id_cidade'];

            $contratante->save();

            return response()->json(
            [
                'message' => 'usuario cadastrado com sucesso',
                'data' => $contratante
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
            Log::error('erro ao buscar usuario' , ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'Error ao buscar prestador'
            ], 500);


        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratante $contratante)
    {
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
