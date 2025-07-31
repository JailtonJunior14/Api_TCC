<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Contratante;
use App\Models\Prestador;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
    public function login(Request $request)
    {
        try {
            $validacao = Validator::make($request->all(),[
                'email' => 'required',
                'password' => 'required'
            ]);
    
            if(!$validacao->fails()){
                
                $token = auth('prestador')->attempt([
                'email' => $request->email,
                'password' => $request->password,
                ]);
                if(!$token){
                    return response()->json([
                        'message' => 'tu não existe'
                    ],401);
                }
    
                $user = auth('prestador')->user();
                return response()->json([
                    'token' => $token,
                    'usuario' => $user
                ]);
            } else {
                return Log::error('deu errado', ['error' => $validacao->errors()->first()]);
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
