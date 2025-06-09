<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class PrestadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prestador = Prestador::all();

        return $prestador;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
                $validacao = $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|unique:prestador,email',
                'password' => 'required|string|confirmed',
                'whatsapp' => 'string|max:18|unique:prestador,whatsapp',
                'fixo' => 'string|max:18|unique:prestador,fixo',
                'foto' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'cep' => 'required|integer',
                'id_cidade' => 'required|integer|exists:cidade,id',
                'id_ramo' => 'required|integer|exists:ramo,id',
                ]);
                $imagem_path = $request->file('foto')->store('fotos', 'public');

                $prestador = new Prestador();
                $prestador->nome = $validacao['nome'];
                $prestador->email = $validacao['email'];
                $prestador->password = Hash::make($validacao['password']);
                $prestador->fixo = $validacao['fixo'];
                $prestador->whatsapp = $validacao['whatsapp'];
                $prestador->foto = $imagem_path;
                $prestador->cep = $validacao['cep'];
                $prestador->id_cidade = $validacao['id_cidade'];
                $prestador->id_ramo = $validacao['id_ramo'];

                $prestador->save();

                // dd(
                //     $validacao['senha'], 
                //     $prestador->senha, 
                //     Hash::check($validacao['senha'], $prestador->senha)
                //   );
                  
                $token = auth('prestador')->attempt([
                    'email' => $validacao['email'],
                    'password' => $validacao['password'],
                ]);


                //dd($token);
                if(!$token){
                    return response()->json([
                        'message' => 'token nao ta sendo gerado'
                    ]);
                }

                $logado = auth('prestador')->user();

                return response()->json([
                    'token' => $token,
                    'prestador' => $logado
                ]);

                // return response()->json(
                //     [
                //         'message' => 'usuario cadastrado com sucesso',
                //        // 'data' => $prestador
                //     ], 201
                // );
        }catch(QueryException $e){
            Log::error('Erro ao salvar no banco', ['error' => $e->getMessage()]);
            
            
            return response()->json([
                'error' => 'Erro ao salvar no banco de dados.'
            ], 500);

            ;
        }catch(Exception $e){
            Log::error('Erro', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $prestador = Prestador::find($id);

            if (!$prestador) {
                return response()->json([ 'error '=>'usuario não encontrado'], 404);
            }
        } catch (Exception $e) {
            Log::error('Erro ao buscar', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => 'error ao buscar'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nome' => 'required|string|max:255',
                'email' => 'required|string|unique:prestador,email,' . $id,
                'senha' => 'required|string|confirmed',
                'whatsapp' => 'string|max:18|unique:prestador,whatsapp',
                'fixo' => 'string|max:18|unique:prestador,fixo',
                'foto' => 'required|string',
                'cep' => 'required|integer|max:9',
                'id_cidade' => 'required|integer|exists:cidade,id',
                'id_ramo' => 'required|integer|exists:ramo,id'
            ]);

            $prestador = Prestador::findoffail($id);

            if ($request->has('nome')){
                $prestador->nome = $request['nome'];
            }
            if ($request->has('email')){
                $prestador->email = $request['email'];
            }
            if ($request->has('senha')){
                $prestador->senha = Hash::make($request['senha']);
            }
            if($request->has('fixo')){
                $prestador->fixo = $request['fixo'];
            }
            if($request->has('whatsapp')){
                $prestador->whatsapp = $request['whatsapp'];
            }
            if ($request->has('foto')){
                $prestador->foto = $request['foto'];
            }
            if ($request->has('cep')){
                $prestador->cep = $request['cep'];
            }
            if ($request->has('id_cidade')){
                $prestador->id_cidade = $request['id_cidade'];
            }
            if ($request->has('id_ramo')){
                $prestador->id_ramo = $request['id_ramo'];
            }

            $prestador->save();
        } catch (ValidationException $e) {
            Log::error('Email já cadastrado', ['error' => $e->getMessage()]);

            response()->json([
                'error' => 'email ja cadastrado'
            ], 422);
        } catch (\Exception $e){
            Log::error('erro ao atualizar', ['error' => $e->getMessage()]);

            response()->json([
                'error' => 'erro ao atualizar'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try
        {
            $prestador = Prestador::find($id);

            if($prestador){
                $prestador->delete();
                return response()->json('excluido com sucesso');
            } else {
                    return response()->json('contratante nao existe');
                }
        
        } catch(\Exception $e){
            Log::error('erro ao excluir', ['error' => $e->getMessage()]);

            response()->json([
                'error' => 'erro ao excluir'
            ],500);
        }

    }
}
