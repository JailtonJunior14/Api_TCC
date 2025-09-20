<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $logado = Auth::guard('user')->user();
            $request->validate([
            'comentario' => 'string|max:255',
            'estrelas' => 'required|integer|max:5',
            'alvo_id' => 'required|integer|exists:users,id'
            ]);
            $avaliacao = new Avaliacao();
            $avaliacao->user_id = $logado->id;
            $avaliacao->comentario = $request->comentario;
            $avaliacao->estrelas = $request->estrelas;
            $avaliacao->alvo_id = $request->alvo_id;
            $avaliacao->save();

            return response()->json([
                        'message' => 'Avaliação cadastrada com sucesso!',
                        'comentario' => $avaliacao->comentario,
                        'estrelas' => $avaliacao->estrelas,
                        'alvo' => $avaliacao->alvo_id
                    ], 201);
        } catch (ValidationException $e) {
           Log::error('Erro validação', [$e->getMessage()]);
           return response()->json([
            'message' => 'erro validação',
            'erro' => $e->errors(),
           ], 422); 
        }catch (QueryException $e){
            Log::error('Erro banco', [$e->getMessage()]);
           return response()->json([
            'message' => 'erro validação',
            'erro' => $e->getMessage(),
           ], 500); 
        }catch (Exception $e){
            Log::error('Erro inesperado', [$e->getMessage()]);
           return response()->json([
            'message' => 'erro validação',
            'erro' => $e->getMessage(),
           ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Avaliacao $Avaliacao)
    {
        try {
            $logado = Auth::guard('user')->user();
            $avaliacao = Avaliacao::where('alvo_id', $logado->id)->selectRaw('AVG(estrelas) as media, COUNT(*) as total')->first();

            // dd($avaliacao);
            return response()->json([
                'nota' => $avaliacao->media,
                'avaliaçoes' => $avaliacao->total
            ]);

        } catch (\Throwable $th) {

        }
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
