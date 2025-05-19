<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use App\Models\Prestador;
use App\Models\Telefone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelefoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $telefones = Telefone::All();

        return $telefones;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try {
         $request->validate([
            'numero' => 'required|string',
            'owner_type' => 'required|in:contratante,prestador',
            'owner_id' => 'required|integer',
            ]);

            $owner = null;
            
            if ($request->owner_type === 'prestador')
            {
                $owner = Prestador::findorfail($request['owner_id']);
            } else if ($request->owner_type === 'contratante')
            {
                $owner = Contratante::findorfail($request['owner_id']);
            }

            $telefone = $owner->telefones()->create([
                'numero' => $request->numero,
            ]);

            return response()->json(
                $telefone, 201
            );

            } catch(\Exception $e){
                Log::error('erro ao cadastrar' , ['error'=> $e->getMessage()]);

                return response()->json([
                'error' => 'Erro ao salvar no banco de dados.'
            ], 500);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Telefone $telefone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Telefone $telefone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Telefone $telefone)
    {
        //
    }
}
