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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Busca todos os usuários com seus relacionamentos
            $usuarios = User::with([
                'prestador.ramo',
                'empresa.categoria', 
                'contratante',
                'contato'
            ])
            ->get()
            ->map(function ($user) {
                // Dados base
                $data = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'type' => $user->type,
                ];
    
                // Adiciona dados do contato
                if ($user->contato) {
                    $data['contato'] = [
                        'telefone' => $user->contato->telefone,
                        'whatsapp' => $user->contato->whatsapp,
                        'site' => $user->contato->site,
                        'instagram' => $user->contato->instagram,
                    ];
                }
    
                // Adiciona avaliações
                $avaliacoes = Avaliacao::where('alvo_id', $user->id)
                    ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                    ->first();
                
                $data['avaliacao'] = [
                    'media' => $avaliacoes->media ?? 0,
                    'total' => $avaliacoes->total ?? 0
                ];
    
                // Adiciona dados específicos de acordo com o tipo
                switch ($user->type) {
                    case 'prestador':
                        if ($user->prestador) {
                            $data['prestador'] = [
                                'nome' => $user->prestador->nome,
                                'cpf' => $user->prestador->cpf,
                                'foto' => $user->prestador->foto ? asset(Storage::url($user->prestador->foto)) : null,
                                'capa' => $user->prestador->capa ? asset(Storage::url($user->prestador->capa)) : null,
                                'localidade' => $user->prestador->localidade,
                                'uf' => $user->prestador->uf,
                                'estado' => $user->prestador->estado,
                                'cep' => $user->prestador->cep,
                                'rua' => $user->prestador->rua,
                                'numero' => $user->prestador->numero,
                                'infoadd' => $user->prestador->infoadd,
                                'descricao' => $user->prestador->descricao,
                            ];
                            
                            if ($user->prestador->ramo) {
                                $data['ramo'] = [
                                    'id' => $user->prestador->ramo->id,
                                    'nome' => $user->prestador->ramo->nome
                                ];
                            }
                        }
                        break;
    
                    case 'empresa':
                        if ($user->empresa) {
                            $data['empresa'] = [
                                'razao_social' => $user->empresa->razao_social,
                                'cnpj' => $user->empresa->cnpj,
                                'foto' => $user->empresa->foto ? asset(Storage::url($user->empresa->foto)) : null,
                                'capa' => $user->empresa->capa ? asset(Storage::url($user->empresa->capa)) : null,
                                'localidade' => $user->empresa->localidade,
                                'uf' => $user->empresa->uf,
                                'estado' => $user->empresa->estado,
                                'descricao' => $user->empresa->descricao,
                            ];
    
                            if ($user->empresa->categoria) {
                                $data['categoria'] = [
                                    'id' => $user->empresa->categoria->id,
                                    'nome' => $user->empresa->categoria->nome
                                ];
                            }
                        }
                        break;
    
                    case 'contratante':
                        if ($user->contratante) {
                            $data['contratante'] = [
                                'nome' => $user->contratante->nome,
                                'cpf' => $user->contratante->cpf,
                                'foto' => $user->contratante->foto ? asset(Storage::url($user->contratante->foto)) : null,
                                'localidade' => $user->contratante->localidade,
                                'uf' => $user->contratante->uf,
                            ];
                        }
                        break;
                }
    
                return $data;
            });
    
            return response()->json($usuarios);
    
        } catch (Exception $e) {
            Log::error('Erro ao buscar usuários:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'error' => 'Erro ao buscar usuários',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'type' => 'required|in:empresa,prestador,contratante',
                'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
                'telefone' => 'required|string|unique:contatos,telefone',
                'localidade' => 'required|string|max:255',
                'uf' => 'string|max:2',
                'estado' => 'required|string|max:255',
                'cep' => 'required|string|max:10',
                'rua' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'infoadd' => 'nullable|sometimes|string|max:255',
                'cnpj' => 'nullable|required_if:type,empresa',
                'razao_social' => 'required_if:type,empresa',
                'id_ramo' => 'nullable|required_if:type,prestador|integer|exists:ramo,id',
                'id_categoria' => 'nullable|required_if:type,empresa|integer|exists:categoria,id',
                'cpf' => 'required_if:type,prestador,contratante',
                'nome' => 'nullable|required_if:type,contratante,prestador',
            ]);

            $imagem_path = $request->hasFile('foto')
                ? $request->file('foto')->store('fotos/perfil', 'public')
                : null;

            $user = new User;
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->type = $request['type'];
            $user->save();

            $contatos = new Contato;
            $contatos->user_id = $user->id;
            $contatos->telefone = $request->telefone;
            $contatos->save();

            switch ($request->type) {
                case 'empresa':
                    $empresa = new Empresa;
                    $empresa->user_id = $user->id;
                    $empresa->cnpj = $request->cnpj;
                    $empresa->razao_social = $request->razao_social;
                    $empresa->id_categoria = $request->id_categoria;
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
                    $prestador = new Prestador;
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
                    $contratante = new Contratante;
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

            $credentials = $request->only('email', 'password');
            $token = auth('user')->attempt($credentials);

            if (!$token) {
                return response()->json([
                    'error' => 'Falha ao gerar token',
                ], 401);
            }

            $logado = auth('user')->user();
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
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();

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
                        'user' => $prestador,
                        'foto' => $prestador->foto ? asset(Storage::url($prestador->foto)) : null,
                        'ramo' => $ramo,
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                        'skills' => $prestador->load('skills'),
                    ]);

                default:
                    return response()->json(['error' => 'Tipo de usuário inválido'], 400);
            }

        } catch (ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
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

    public function select()
    {
        $logado = Auth::guard('user')->user();

        switch ($logado->type) {
            case 'empresa':
                $empresa = Empresa::where('user_id', $logado->id)->first();
                $ramo = Ramo::where('id', $empresa->id_ramo)->first();

                return response()->json([
                    'message' => 'empresa',
                    'user' => $empresa,
                    'foto' => $empresa->foto ? Storage::url($empresa->foto) : null,
                    'ramo' => $ramo,
                ]);

            case 'contratante':
                $contratante = Contratante::where('user_id', $logado->id)->first();

                return response()->json([
                    'message' => 'contratante',
                    'user' => $contratante,
                ]);

            case 'prestador':
                $prestador = Prestador::where('user_id', $logado->id)->first();

                return response()->json([
                    'message' => 'prestador',
                    'user' => $prestador,
                ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $logado = Auth::guard('user')->user();

            if (!$logado) {
                return response()->json([
                    'message' => 'Usuário não autenticado',
                ], 401);
            }

            $request->validate([
                'email' => [
                    'sometimes', 'email',
                    Rule::unique('users', 'email')->ignore($logado->id),
                ],
                'password' => 'sometimes|string|min:6',
                'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'capa' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'telefone' => [
                    'sometimes', 'string',
                    Rule::unique('contatos', 'telefone')->ignore($logado->id, 'user_id'),
                ],
                'whatsapp' => 'sometimes|string',
                'site' => [
                    'sometimes', 'string',
                    Rule::unique('contatos', 'site')->ignore($logado->id, 'user_id'),
                ],
                'instagram' => [
                    'sometimes', 'string',
                    Rule::unique('contatos', 'instagram')->ignore($logado->id, 'user_id'),
                ],
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
                'descricao' => 'sometimes|string',
                'skills' => 'sometimes|array',
                'skills.*' => 'sometimes|integer|exists:skills,id',
            ]);

            $usuario = User::findOrFail($logado->id);

            if ($request->has('email')) {
                $usuario->email = $request->email;
            }

            if ($request->has('password')) {
                $usuario->password = Hash::make($request->password);
            }

            $usuario->save();

            // Atualiza contatos
            if ($request->hasAny(['telefone', 'whatsapp', 'site', 'instagram'])) {
                $contato = $usuario->contato;
                $contato->fill($request->only(['telefone', 'whatsapp', 'site', 'instagram']));
                $contato->save();
            }

            $contato = Contato::where('user_id', $logado->id)->first();

            switch ($logado->type) {
                case 'contratante':
                    $contratante = $logado->contratante;
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();

                    $dados = $request->only([
                        'nome', 'cpf', 'localidade', 'uf', 'estado', 'cep', 'rua', 'numero', 'infoadd',
                    ]);
                    $dados = array_filter($dados, fn ($valor) => !is_null($valor));
                    $contratante->fill($dados);

                    if ($request->hasFile('foto')) {
                        $path = $request->file('foto')->store('fotos/perfil', 'public');
                        $contratante->foto = $path;
                    }

                    $contratante->save();

                    return response()->json([
                        'logado' => $logado,
                        'user' => $contratante,
                        'foto' => $contratante->foto ? asset(Storage::url($contratante->foto)) : null,
                        'capa' => $contratante->capa ? asset(Storage::url($contratante->capa)) : null,
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                    ]);

                case 'prestador':
                    $prestador = $logado->prestador;
                    $ramo = Ramo::where('id', $prestador->id_ramo)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();

                    $dados = $request->only([
                        'nome', 'cpf', 'id_ramo', 'localidade', 'uf', 'estado', 
                        'cep', 'numero', 'rua', 'infoadd', 'descricao',
                    ]);
                    $dados = array_filter($dados, fn ($valor) => !is_null($valor));
                    $prestador->fill($dados);

                    if ($request->hasFile('foto')) {
                        $path = $request->file('foto')->store('fotos/perfil', 'public');
                        $prestador->foto = $path;
                    }

                    if ($request->hasFile('capa')) {
                        $path = $request->file('capa')->store('fotos/capa', 'public');
                        $prestador->capa = $path;
                    }

                    if ($request->has('skills')) {
                        $prestador->skills()->sync($request->skills);
                    }

                    $prestador->save();

                    return response()->json([
                        'logado' => $logado,
                        'user' => $prestador,
                        'foto' => $prestador->foto ? asset(Storage::url($prestador->foto)) : null,
                        'capa' => $prestador->capa ? asset(Storage::url($prestador->capa)) : null,
                        'ramo' => $ramo,
                        'skills' => $prestador->load('skills'),
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                    ]);

                case 'empresa':
                    $empresa = $logado->empresa;
                    $categoria = Categoria::where('id', $empresa->id_categoria)->first();
                    $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                        ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                        ->first();

                    $dados = $request->only([
                        'razao_social', 'cnpj', 'id_categoria', 'descricao',
                        'localidade', 'uf', 'estado', 'cep', 'rua', 'numero', 'infoadd',
                    ]);
                    $empresa->fill($dados);

                    if ($request->hasFile('foto')) {
                        $path = $request->file('foto')->store('fotos/perfil', 'public');
                        $empresa->foto = $path;
                    }

                    if ($request->hasFile('capa')) {
                        $path = $request->file('capa')->store('fotos/capa', 'public');
                        $empresa->capa = $path;
                    }

                    $empresa->save();

                    return response()->json([
                        'logado' => $logado,
                        'user' => $empresa,
                        'foto' => $empresa->foto ? asset(Storage::url($empresa->foto)) : null,
                        'capa' => $empresa->capa ? asset(Storage::url($empresa->capa)) : null,
                        'categoria' => $categoria,
                        'avaliacao' => $avaliacao,
                        'contatos' => $contato,
                    ]);

                default:
                    return response()->json(['error' => 'Tipo de usuário inválido'], 400);
            }

        } catch (ValidationException $e) {
            Log::error('Erro de validação', ['errors' => $e->errors()]);
            return response()->json([
                'error' => 'Erro de validação',
                'details' => $e->errors(),
            ], 422);

        } catch (QueryException $e) {
            Log::error('Erro no banco de dados', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erro no banco de dados',
                'details' => $e->getMessage(),
            ], 500);

        } catch (Exception $e) {
            Log::error('Erro geral', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erro inesperado',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function selectID(int $id)
{
    try {
        $user = User::with([
            'prestador.ramo',
            'prestador.skills',
            'empresa.categoria',
            'contratante',
            'portfolios.fotos',
            'portfolios.videos',
            'avaliacoes',
            'contato',
        ])->findOrFail($id);

        return response()->json([
            'user' => $user // IMPORTANTE: retornar com a chave 'user'
        ]);

    } catch (Exception $e) {
        Log::error('Erro ao buscar usuário por ID', [
            'id' => $id,
            'message' => $e->getMessage()
        ]);

        return response()->json([
            'error' => 'Usuário não encontrado',
            'message' => $e->getMessage()
        ], 404);
    }
}

    public function destroy()
    {
        //
    }
}