<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cidade = Cidade::all();

        return $cidade;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $cidade = Cidade::find($id);

        if (!$cidade) {
            return response()->json(['mensagem' => 'Cidade não encontrada'], 404);
        }

        return response()->json($cidade);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function listarporEstado($estadoId)
    {
        $cidades = Cidade::where('estado_id', $estadoId)->get();

        return response()->json($cidades);

    }
}
