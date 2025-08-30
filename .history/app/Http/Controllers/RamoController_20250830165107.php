<?php

namespace App\Http\Controllers;

use App\Models\Ramo;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ramos = Ramo::all();

        return $ramos;
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
    public function show(string $modalidade, string $nome = null)
    {
        try {
            $modalidade = Ramo::where('modalidade','=', $modalidade)->get();
            return $modalidade;
        } catch (QueryException $e) {
            Log::error('erro ao buscar', ['error' =>$e->getMessage()]);
        }catch (Exception $e) {
            Log::error('erro', ['error' =>$e->getMessage()]);
        }
    }

}
