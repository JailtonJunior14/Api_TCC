<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Empresa;
use App\Models\Contratante;
use App\Models\Prestador;
use App\Models\Ramo;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;

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
            $token = Auth::guard('user')->attempt($credentials);
            $logado = Auth::guard('user')->user();
            // dd($logado);
            switch($logado->type){
                case "empresa":
                    $empresa = Empresa::where('user_id', $logado->id)->first();
                    $ramo = Ramo::where('id', $empresa->id_ramo)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)->selectRaw('AVG(estrelas) as media, COUNT(*) as total')->first();

                    // dd($ramo->nome);
                    // dd($empresa);
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $empresa,
                        'foto' => $empresa->foto ? asset(Storage::url($empresa->foto)) : null,
                        'ramo' => $ramo,
                        'avaliacao' => $avaliacao
                    ]);
                    break;
                case "contratante":
                    $contratante = Contratante::where('user_id', $logado->id)->first();
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $contratante,
                        'foto' => $contratante->foto ? asset(Storage::url($contratante->foto)) : null,
                    ]);
                    break;
                case "prestador":
                    $prestador = Prestador::where('user_id', $logado->id)->first();
                    $ramo = Ramo::where('id', $prestador->id_ramo)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)->selectRaw('AVG(estrelas) as media, COUNT(*) as total')->first();
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $prestador,
                        'foto' => $prestador->foto ? asset(Storage::url($prestador->foto)) : null,
                        'ramo' => $ramo,
                        'avaliacao' => $avaliacao
                    ]);
                    break;
                default:
                    return response()->json([
                        'message' => 'erro'
                    ]);
            }

                // if ($token) {
                //     return response()->json([
                //         'access_token' => $token,
                //         'token_type' => 'bearer',
                //         'user' => $logado,
                //     ]);
                // }

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
        try {
        $token = JWTAuth::getToken(); // pega o token enviado no header
        if (!$token) {
            return response()->json(['error' => 'Token não fornecido'], 400);
        }

        JWTAuth::invalidate($token); // invalida o token
        return response()->json(['message' => 'Logout realizado com sucesso!']);
    } catch (JWTException $e) {
        return response()->json(['error' => 'Falha ao invalidar token'], 500);
    }
    }
}
