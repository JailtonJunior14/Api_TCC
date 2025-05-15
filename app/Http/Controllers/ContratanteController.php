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
        $new_contratante = new Contratante();

        $new_contratante->nome = 'tigas';
        $new_contratante->email = 'tiga@teste.com';
        $new_contratante->senha = 'tig@s';
        $new_contratante->id_cidade = 2;

        $new_contratante->save();

        dd($new_contratante);

    }

    /**
     * Display the specified resource.
     */
    public function show(Contratante $contratante)
    {
        $contratante = Contratante::find(2);

        return $contratante;
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
}
