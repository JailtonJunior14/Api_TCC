<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Illuminate\Http\Request;

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
    }

    /**
     * Display the specified resource.
     */
    public function show(Prestador $prestador)
    {
        //
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
