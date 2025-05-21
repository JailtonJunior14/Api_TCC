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
                'senha' => 'required|string|confirmed',
                'whatsapp' => 'string|max:18|unique:empresa,whatsapp',
                'fixo' => 'string|max:18|unique:empresa,fixo',
                'foto' => 'required|string',
                'cnpj' => 'required|string',
                'cep' => 'required|string',
                'id_cidade' => 'required|integer|exists:cidade,id',
                'id_ramo' => 'required|integer|exists:ramo,id'
            ]);

            $empresa = new Empresa();

            $empresa->nome = $validacao['nome'];
            $empresa->email = $validacao['email'];
            $empresa->senha = Hash::make($validacao['senha']);
            $empresa->whatsapp = $validacao['whatsapp'];
            $empresa->fixo = $validacao['fixo'];
            $empresa->foto = $validacao['foto'];
            $empresa->cnpj = $validacao['cnpj'];
            $empresa->cep = $validacao['cep'];
            $empresa->id_cidade = $validacao['id_cidade'];
            $empresa->id_ramo = $validacao['id_ramo'];

            $empresa->save();

            return response()->json([
                'message' => 'empresa cadastrada com sucesso',
                'data' => $empresa
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
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        //
    }
}
