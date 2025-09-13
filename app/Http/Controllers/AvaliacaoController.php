<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Avaliacao::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
            'descricao' => 'required|string',
            'id_prestador_destino' => 'integer|exists:prestador,id',
            'id_empresa_destino' => 'integer|exists:empresa,id',
            'id_empresa_autor' => 'integer|exists:empresa,id',
            'id_contratante_autor' => 'integer|exists:contratante,id'
            ]);

            $Avaliacao = new Avaliacao();
            $Avaliacao->descricao = $request['descricao'];
            $Avaliacao->id_prestador_destino = $request['id_prestador_destino'];
            $Avaliacao->id_empresa_destino = $request['id_empresa_destino'];
            $Avaliacao->id_empresa_autor = $request['id_empresa_autor'];
            $Avaliacao->id_contratante_autor = $request['id_contratante_autor'];

            $Avaliacao->save();
        } catch (ValidationException $e) {
            Log::error('erro de validação', ['error' => $e->getMessage()]);
        } catch (QueryException $e){
            Log::error('erro ao salvar no banco', ['error' => $e->getMessage()]);
        } catch (Exception $e){
            Log::error('erro', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Avaliacao $Avaliacao)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Avaliacao $Avaliacao)
    {
        try {
            
        } catch (\Throwable $th) {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Avaliacao = Avaliacao::find($id);

        if($Avaliacao){
            $Avaliacao->delete();
        } 
    }
}
