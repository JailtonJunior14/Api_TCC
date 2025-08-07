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
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // try {
        //     $validacao = Validator::make($request->all(),[
        //         'email' => 'required',
        //         'password' => 'required'
        //     ]);
    
        //     if(!$validacao->fails()){
                
        //         $token = auth('prestador')->attempt([
        //         'email' => $request->email,
        //         'password' => $request->password,
        //         ]);
        //         if(!$token){
        //             return response()->json([
        //                 'message' => 'tu não existe'
        //             ],401);
        //         }
    
        //         $user = auth('prestador')->user();
        //         return response()->json([
        //             'token' => $token,
        //             'usuario' => $user
        //         ]);
        //     } else {
        //         return Log::error('deu errado', ['error' => $validacao->errors()->first()]);
        //     }
    
        // }catch(ValidationException $e){
        //     Log::error('ta errado algo', ['error' => $e->getMessage()]);
        // }
        // catch(QueryException $e){
        //     Log::error('deu errado bd', ['error' => $e->getMessage()]);
        // } 
        // catch (Exception $e) {
        //     Log::error('deu errado', ['error' => $e->getMessage()]);
        // }
        try {
            $credentials = $request->only('email', 'password');

        // Tenta autenticar com cada guard
            $guards = ['contratante', 'empresa', 'prestador'];

            foreach ($guards as $guard) {
                if ($token = Auth::guard($guard)->attempt($credentials)) {
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'guard' => $guard, // informa o tipo
                        'user' => Auth::guard($guard)->user(),
                    ]);
                }
            }

            return response()->json(['error' => 'Credenciais inválidas'], 401);
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



    public function Logout(string $id)
    {
        //
    }
}
