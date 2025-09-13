<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PortfolioController extends Controller
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
        try {
            $request->validate([
                'imagem' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'descricao' => 'required|string',
                'user_id' => 'sometimes|integer|exists:users,id',
            ]);


            $imagem_path = $request->file('imagem')->store('fotos/portfolio', 'public');
            $portfolio = new Portfolio();

            $portfolio->descricao = $request['descricao'];
            $portfolio->imagem = $imagem_path;
            $portfolio->user_id = $request['user_id'];
            $portfolio->save();



        } catch (ValidationException $e) {
            Log::error('erro de validação', ['error' => $e->getMessage()]);
        } catch (QueryException $e){
            Log::error('erro de banco', ['error' => $e->getMessage()]);
        } catch(Exception $e){
            Log::error('erro', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
