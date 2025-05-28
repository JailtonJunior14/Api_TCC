<?php

namespace App\Http\Controllers;

use App\Models\Links;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Links::all();
        return $links;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'link' => 'url',
                'id_prestador' => 'exists:prestador,id,',
                'id_empresa' => 'exists:empresa,id'
            ]);

            $link = new Links();
            $link->link = $request['link'];
            $link->id_prestador = $request['id_prestador'];
            $link->id_empresa = $request['id_empresa'];
        } catch (QueryException $e) {
            Log::error('erro do banco', ['error' => $e->getMessage()]);
        } catch (Exception $e) {
            Log::error('erro', ['error' => $e->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Links $links)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Links $links)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Links $links)
    {
        //
    }
}
