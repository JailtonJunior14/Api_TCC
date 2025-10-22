<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Contratante;
use App\Models\Empresa;
use App\Models\Prestador;
use App\Models\Ramo;
use App\Models\Telefone;
use App\Models\User;
use App\Models\Users;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return response()->json([
        'message' => 'index users controller'
       ]);
    }

    public function store(Request $request)
    {
       try{ 
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'type' => 'required|in:empresa,prestador,contratante',
                'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'telefone' => 'required|string|unique:telefone,telefone',
                'localidade' => 'required|string|max:255',
                'uf' => 'string|max:2',
                'estado' => 'required|string|max:255',
                'cep' => 'required|string|max:10',
                'rua' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'infoadd' => 'required|string|max:255',
                // dados específicos (validação condicional)
                'cnpj' => 'required_if:type,empresa',
                'razao_social' => 'required_if:type,empresa',
                'id_ramo' => 'required_if:type,empresa,prestador|integer|exists:ramo,id',
                'cpf' => 'required_if:type,prestador,contratante',
                'nome' => 'required_if:type,contratante,prestador',
            ]);

            $imagem_path = $request->hasFile('foto')
            ? $request->file('foto')->store('fotos', 'public')
            : null;
            // dd($imagem_path);
            $user = new User();
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->type = $request['type'];
            $user->save();

            $telefone = new Telefone();
            $telefone->user_id = $user->id;
            $telefone->telefone = $request->telefone;
            $telefone->save();

            switch ($request->type) {
                case 'empresa':
                    $empresa = new Empresa();
                    $empresa->user_id = $user->id;
                    $empresa->cnpj = $request->cnpj;
                    $empresa->razao_social = $request->razao_social;
                    $empresa->id_ramo = $request->id_ramo;
                    $empresa->foto = $imagem_path;
                    $empresa->localidade = $request->localidade;
                    $empresa->uf = $request->uf;
                    $empresa->estado = $request->estado;
                    $empresa->cep = $request->cep;
                    $empresa->rua = $request->rua;
                    $empresa->numero = $request->numero;
                    $empresa->infoadd = $request->infoadd;

                    $empresa->save();
                    break;

                case 'prestador':
                    $prestador = new Prestador();
                    $prestador->user_id = $user->id;
                    $prestador->nome = $request->nome;
                    $prestador->cpf = $request->cpf;
                    $prestador->id_ramo = $request->id_ramo;
                    $prestador->foto = $imagem_path;
                    $prestador->localidade = $request->localidade;
                    $prestador->uf = $request->uf;
                    $prestador->estado = $request->estado;
                    $prestador->cep = $request->cep;
                    $prestador->rua = $request->rua;
                    $prestador->numero = $request->numero;
                    $prestador->infoadd = $request->infoadd;

                    $prestador->save();
                    break;

                case 'contratante':
                    $contratante = new Contratante();
                    $contratante->user_id = $user->id;
                    $contratante->nome = $request->nome;
                    $contratante->cpf = $request->cpf;
                    $contratante->foto = $imagem_path;
                    $contratante->localidade = $request->localidade;
                    $contratante->uf = $request->uf;
                    $contratante->estado = $request->estado;
                    $contratante->cep = $request->cep;
                    $contratante->rua = $request->rua;
                    $contratante->numero = $request->numero;
                    $contratante->infoadd = $request->infoadd;
                    $contratante->save();
                    break;
            }

                    $token = auth('user')->attempt([
                                    'email' => $request['email'],
                                    'password' => $request['password']
                                ]);

                                if(!$token){
                                    return response()->json([
                                        'error' => 'token não ta sendo gerado'
                                    ]);
                                }

                                $logado = auth('user')->user();

                    // return response()->json([
                    //     'message' => 'Usuário cadastrado com sucesso!',
                    //     'user' => $user->load($user->type),
                    //     'token' => $token,
                    //     'logado' => $logado
                    // ], 201);
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
                            $avaliacao = Avaliacao::where('alvo_id', $logado->id)->selectRaw('AVG(estrelas) as media, COUNT(*) as total')->first();
                            return response()->json([
                                'access_token' => $token,
                                'token_type' => 'bearer',
                                'logado' => $logado,
                                'user' => $contratante,
                                'foto' => $contratante->foto ? asset(Storage::url($contratante->foto)) : null,
                                // 'ramo' => $ramo,
                                // 'avaliacao' => $avaliacao
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
        }
                        catch (ValidationException $e) {
                        Log::error('Validation error', ['message' => $e->getMessage()]);
                        return response()->json([
                            'error' => 'Erro de validação',
                            'details' => $e->errors(),
                        ], 422);
                    } catch (QueryException $e) {
                        Log::error('Database error', ['message' => $e->getMessage()]);
                        return response()->json([
                            'error' => 'Erro no banco de dados',
                            'details' => $e->getMessage(),
                        ], 500);
                    } catch (Exception $e) {
                        Log::error('General error', ['message' => $e->getMessage()]);
                        return response()->json([
                            'error' => 'Erro inesperado',
                            'details' => $e->getMessage(),
                        ], 500);
                    }

    }

    public function select(){
        $logado = Auth::guard('user')->user();

        // return response()->json([
        //     'message' => $logado
        // ]);
        // $empresa = Empresa::findOr($logado->id);
        // dd($empresa);

        switch($logado->type){
            case "empresa":
                $empresa = Empresa::where('user_id', $logado->id)->first();
                $ramo = Ramo::where('id', $empresa->id_ramo)->first();
                // dd($ramo->nome);
                // dd($empresa);
                return response()->json([
                    'message' => 'empresa',
                    'user' => $empresa,
                    'foto' => $empresa->foto ? Storage::url($empresa->foto) : null,
                    'ramo' => $ramo
                ]);
                break;
            case "contratante":
                $contratante = Contratante::where('user_id', $logado->id)->first();
                return response()->json([
                    'message' => 'contratante',
                    'user' => $contratante
                ]);
                break;
            case "prestador":
                $prestador = Prestador::where('user_id', $logado->id)->first();
                return response()->json([
                    'message' => 'prestador',
                    'user' => $prestador
                ]);
        }
    }
    public function update(Request $request)
    {
        try {
            $logado = Auth::guard('user')->user();
            // dd($logado->id);
             if(!$logado){
                response()->json([
                    'message' => 'usuario não autenticado'
                ]);
            }

            $request->validate([
            'email' => 'sometimes|email|unique:users,email,' . $logado->id,
            'password' => 'sometimes|string|min:6',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'telefone' => 'sometimes|string',
            'localidade' => 'sometimes|string|max:255',
            'uf' => 'sometimes|string|max:2',
            'estado' => 'sometimes|string|max:255',
            'cep' => 'sometimes|string|max:10',
            'rua' => 'sometimes|string|max:255',
            'numero' => 'sometimes|string|max:255',
            'infoadd' => 'sometimes|string|max:255',
            'cnpj' => 'sometimes|string',
            'razao_social' => 'sometimes|string',
            'id_ramo' => 'sometimes|integer|exists:ramo,id',
            'cpf' => 'sometimes|string',
            'nome' => 'sometimes|string',
            ]);
             $userID = $logado->id;

            $usuario = User::findOrFail($userID);
            // var_dump($usuario);


            if($request->has('email')){
                $usuario->email = $request['email'];
                // return response()->json([
                //     'message' => 'toaqui'
                // ]);
            }

            if($request->has('password')){
                $usuario->password = Hash::make($request->password);
            }

            if($request->has('telefone')){
                $telefone = $usuario->telefone;
                $telefone->telefone = $request->telefone;
                $telefone->save();
            }

            $usuario->save();
            switch ($logado->type) {
                case 'contratante':
                    $contratante = $logado->contratante;
                    $contratante->fill($request->only([
                        'nome', 'cpf', 'localidade', 'uf', 'estado', 'cep', 'rua','numero', 'infoadd'
                    ]));
                    if($request->has('foto')){
                        $path = $request->file('foto')->store('fotos', 'public');
                        $contratante->foto = $path;
                    }
                    $contratante->save();
                    break;
                case 'prestador':
                    $prestador = $logado->prestador;
                    $prestador->fill($request->only([
                        'nome','cpf', 'foto', 'cep', 'id_ramo', 'localidade', 'uf', 'estado', 'cep','numero', 'rua', 'infoadd'
                    ]));
                    if($request->has('foto')){
                        $path = $request->file('foto')->store('fotos', 'public');
                        $prestador->foto = $path;
                    }
                    $prestador->save();
                    break;
                case 'prestador':
                    $empresa = $logado->empresa;
                    $empresa->fill($request->only([
                        'razao_social','whatsapp','fixo', 'foto', 'cnpj','id_ramo','localidade', 'uf', 'estado', 'cep', 'rua', 'numero', 'infoadd'
                    ]));
                    if($request->has('foto')){
                        $path = $request->file('foto')->store('fotos', 'public');
                        $empresa->foto = $path;
                    }
                    $empresa->save();
                    break;

                
                default:
                return response()->json([
                    'message' => 'deu merda'
                ]);
                    break;
            }
        } catch (ValidationException $e) {
            Log::error('erro validaçao', [$e->getMessage()]);
        }catch (QueryException $e) {
            Log::error('erro validaçao', [$e->getMessage()]);
        }catch (Exception $e) {
            Log::error('erro validaçao', [$e->getMessage()]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
