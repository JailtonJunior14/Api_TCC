<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
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
    public function logar(Request $request)
    {
        try {
            $request->validate([
                'email'=> 'required|email',
                'senha'=> 'required',
                'tipo' => 'required'
            ]);
    
            if($request['tipo'] == 'contratante'){
                $contratante = Contratante::where('email', $request->input('email'))->first(); //first() retorna apenas o primeiro resultado do banco
                if(!$contratante){
                    return response()->json([
                        'message' => 'nao existe'
                    ]);
                }
                if(!password_verify($request->input('senha'), $contratante->senha)){
                    return response()->json([
                        'message' => 'nao existe'
                    ]);
                }

                return response()->json([
                    'message' => 'deu certo'
                ]);

            }
        }catch(ValidationException $e){
            Log::error('ta errado algo', ['error' => $e->getMessage()]);
        }
        catch(QueryException $e){
            Log::error('deu errado bd', ['error' => $e->getMessage()]);
        } 
        catch (Exception $e) {
            Log::error('deu errado', ['error' => $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
