<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $pais = Pais::all();

<<<<<<< HEAD
        // return $pais;

        $senha = Hash::make('cabopartrançadoblindado');
        dd($senha);
=======
        //return $pais;
        dd($pais);
>>>>>>> 216dfc3c969193680c599a728d6ae5b5c97f5477
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
    public function show(Pais $pais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pais $pais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pais $pais)
    {
        //
    }
}
