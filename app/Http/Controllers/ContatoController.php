<?php

namespace App\Http\Controllers;

use App\Models\Contatos;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContatosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Contatos = Contatos::all();
        return $Contatos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
 
            $request->validate([
                'whatsapp' => 'unique:telefone,telefone',
                'telefone' => 'unique:telefone,telefone',
                'instagram' => 'string|unique:contatos,instagram',
                'site' => 'string|unique:contatos,site',
            ]);
            $logado = Auth::guard('user')->user();

            $contatos = new Contatos();

            $contatos->user_id = $logado->id;
            $contatos->whatsapp = $request->whatsapp;
            $contatos->telefone = $request->telefone;
            $contatos->instagram = $request->instagram;
            $contatos->site = $request->site;




        } catch (QueryException $e) {
            Log::error('erro do banco', ['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::error('erro', ['error' => $e->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Contatos $Contatos)
    {
        $logado = Auth::guard('user')->user();

        $contatos = Contatos::where('user_id', $logado->id);

        return response()->json($contatos);
    }

    
    public function update(Request $request, Contatos $Contatos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contatos $Contatos)
    {
        //
    }
}
