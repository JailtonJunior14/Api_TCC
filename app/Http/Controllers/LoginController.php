<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Categoria;
use App\Models\Contato;
use App\Models\Contratante;
use App\Models\Empresa;
use App\Models\Prestador;
use App\Models\Ramo;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $token = Auth::guard('user')->attempt($credentials);
    
            // CORRIGIDO: Verificar o token PRIMEIRO
            if (!$token) {
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
    
            // Agora sim buscar os dados (só executa se login for válido)
            $logado = Auth::guard('user')->user();
            $contato = Contato::where('user_id', $logado->id)->first();
    
            switch ($logado->type) {
                case 'empresa':
                    $empresa = Empresa::where('user_id', $logado->id)->first();
                    $categoria = Categoria::where('id', $empresa->id_categoria)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();
    
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $empresa,
                        'foto' => $empresa->foto ? asset(Storage::url($empresa->foto)) : null,
                        'categoria' => $categoria,
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                    ]);
    
                case 'contratante':
                    $contratante = Contratante::where('user_id', $logado->id)->first();
    
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $contratante,
                        'foto' => $contratante->foto ? asset(Storage::url($contratante->foto)) : null,
                        'contatos' => $contato,
                    ]);
    
                case 'prestador':
                    $prestador = Prestador::where('user_id', $logado->id)->first();
                    $ramo = Ramo::where('id', $prestador->id_ramo)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();
    
                    return response()->json([
                        'access_token' => $token,
                        'token_type' => 'bearer',
                        'logado' => $logado,
                        'user' => $prestador->load('skills'),
                        'foto' => $prestador->foto ? asset(Storage::url($prestador->foto)) : null,
                        'ramo' => $ramo,
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                    ]);
    
                default:
                    return response()->json(['message' => 'erro'], 400);
            }
    
        } catch (ValidationException $e) {
            Log::error('ta errado algo', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro de validação'], 422);
        } catch (QueryException $e) {
            Log::error('deu errado bd', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro no banco de dados'], 500);
        } catch (Exception $e) {
            Log::error('deu errado login', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Erro ao realizar login'], 500);
        }
    }

    public function Logout(string $id)
    {
        try {
            $token = JWTAuth::getToken(); // pega o token enviado no header
            if (! $token) {
                return response()->json(['error' => 'Token não fornecido'], 400);
            }

            JWTAuth::invalidate($token); // invalida o token

            return response()->json(['message' => 'Logout realizado com sucesso!']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Falha ao invalidar token'], 500);
        }
    }
}
