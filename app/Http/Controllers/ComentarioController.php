<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comentario::all();
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

            $comentario = new Comentario();
            $comentario->descricao = $request['descricao'];
            $comentario->id_prestador_destino = $request['id_prestador_destino'];
            $comentario->id_empresa_destino = $request['id_empresa_destino'];
            $comentario->id_empresa_autor = $request['id_empresa_autor'];
            $comentario->id_contratante_autor = $request['id_contratante_autor'];

            $comentario->save();
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
    public function show(Comentario $comentario)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario)
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
        $comentario = Comentario::find($id);

        if($comentario){
            $comentario->delete();
        } 
    }
}
