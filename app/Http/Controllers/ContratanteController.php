<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use Illuminate\Http\Request;

class ContratanteController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contratante $contratante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contratante $contratante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contratante $contratante)
    {
        //
    }

    public function listarportelefone($telefoneId)
    {
        $telefoneId = Contratante::where('telefone_id', $telefoneId)->get();

        return response()->json($telefoneId);
    }
}
