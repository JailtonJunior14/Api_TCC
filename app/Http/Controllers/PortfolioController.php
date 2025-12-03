<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Video;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PortfolioController extends Controller
{
    /**
     * Criar nova publicação (CORRIGIDO E DEBUG)
     */
    public function store(Request $request)
    {
        try {
            $logado = Auth::guard('user')->user();
            
            if (!$logado) {
                Log::error('❌ Usuário não autenticado tentando criar publicação');
                return response()->json([
                    'message' => 'Usuário não autenticado'
                ], 401);
            }
            
            Log::info('📤 Dados recebidos:', [
                'user_id' => $logado->id,
                'titulo' => $request->input('titulo'),
                'descricao' => $request->input('descricao'),
                'tem_imagens' => $request->hasFile('imagens'),
                'tem_videos' => $request->hasFile('videos'),
                'imagens_count' => $request->hasFile('imagens') ? count($request->file('imagens')) : 0,
                'videos_count' => $request->hasFile('videos') ? count($request->file('videos')) : 0,
            ]);
            
            // Validação (CORRIGIDO)
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'descricao' => 'required|string',
                'imagens' => 'nullable|array',
                'imagens.*' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
                'videos' => 'nullable|array',
                'videos.*' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:10240',
            ]);
            
            Log::info('✅ Validação passou');
            
            // Criar portfolio
            $portfolio = Portfolio::create([
                'user_id' => $logado->id,
                'titulo' => $validated['titulo'],
                'descricao' => $validated['descricao'],
            ]);
            
            Log::info('✅ Portfolio criado:', ['id' => $portfolio->id]);
            
            // Salvar imagens
            if ($request->hasFile('imagens')) {
                Log::info('🖼️ Processando imagens...');
                foreach ($request->file('imagens') as $index => $imagem) {
                    try {
                        $imagem_path = $imagem->store('portfolio/fotos', 'public');
                        
                        Foto::create([
                            'caminho' => $imagem_path,
                            'portfolio_id' => $portfolio->id,
                        ]);
                        
                        Log::info("✅ Imagem {$index} salva:", ['caminho' => $imagem_path]);
                    } catch (Exception $e) {
                        Log::error("❌ Erro ao salvar imagem {$index}:", ['error' => $e->getMessage()]);
                    }
                }
            }
            
            // Salvar vídeos
            if ($request->hasFile('videos')) {
                Log::info('🎥 Processando vídeos...');
                foreach ($request->file('videos') as $index => $video) {
                    try {
                        $video_path = $video->store('portfolio/videos', 'public');
                        
                        Video::create([
                            'caminho' => $video_path,
                            'portfolio_id' => $portfolio->id,
                        ]);
                        
                        Log::info("✅ Vídeo {$index} salvo:", ['caminho' => $video_path]);
                    } catch (Exception $e) {
                        Log::error("❌ Erro ao salvar vídeo {$index}:", ['error' => $e->getMessage()]);
                    }
                }
            }
            
            // Carregar relacionamentos
            $portfolio->load(['fotos', 'videos']);
            
            Log::info('✅ Publicação criada com sucesso:', [
                'portfolio_id' => $portfolio->id,
                'fotos_count' => $portfolio->fotos->count(),
                'videos_count' => $portfolio->videos->count(),
            ]);
            
            return response()->json([
                'message' => 'Publicação criada com sucesso',
                'data' => $portfolio,
            ], 201);
            
        } catch (ValidationException $e) {
            Log::error('❌ Erro de validação:', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('❌ Erro de banco de dados:', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return response()->json([
                'message' => 'Erro ao salvar no banco de dados',
                'error' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            Log::error('❌ Erro geral:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Erro ao criar publicação',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Listar publicações do usuário logado
     */
    public function select()
    {
        try {
            $logado = Auth::guard('user')->user();
            
            $portfolios = Portfolio::with(['fotos', 'videos'])
                ->where('user_id', $logado->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json($portfolios);
        } catch (Exception $e) {
            Log::error('Erro ao listar publicações', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao carregar publicações'], 500);
        }
    }

    /**
     * Listar publicações de um usuário específico
     */
    public function selectIdUser(int $id)
    {
        try {
            $portfolios = Portfolio::with(['fotos', 'videos'])
                ->where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'data' => $portfolios,
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao listar publicações do usuário', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao carregar publicações'], 500);
        }
    }

    /**
     * Buscar publicação específica (CORRIGIDO)
     */
    public function selectId(int $id)
    {
        try {
            $portfolio = Portfolio::with([
                    'fotos',
                    'videos',
                    'user.prestador.ramo',
                    'user.empresa.categoria',
                    'user.avaliacao'
                ])
                ->findOrFail($id);

            return response()->json([
                'data' => $portfolio,
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao buscar publicação', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Publicação não encontrada'], 404);
        }
    }

    /**
     * Listar todas as publicações (feed) - CORRIGIDO
     */
    public function show()
    {
        try {
            $logado = Auth::guard('user')->user();
            
            Log::info('📡 Carregando feed para usuário:', ['user_id' => $logado->id]);
            
            $portfolios = Portfolio::with([
                    'user.prestador.ramo',
                    'user.empresa.categoria',
                    'user.contratante',
                    'user.avaliacao',
                    'fotos',
                    'videos'
                ])
                ->where('user_id', '!=', $logado->id)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            // Formatar dados do usuário
            $portfolios->getCollection()->transform(function ($item) {
                $tipo = $item->user->tipo_conta ?? null;
                
                if ($tipo === 'prestador' && $item->user->prestador) {
                    $item->user_nome = $item->user->prestador->nome;
                    $item->user_foto = $item->user->prestador->foto;
                    $item->user_ramo = $item->user->prestador->ramo->nome ?? null;
                    $item->user_cidade = $item->user->prestador->localidade ?? null;
                    $item->user_estado = $item->user->prestador->uf ?? null;
                    
                } elseif ($tipo === 'empresa' && $item->user->empresa) {
                    $item->user_nome = $item->user->empresa->razao_social;
                    $item->user_foto = $item->user->empresa->foto;
                    $item->user_ramo = $item->user->empresa->categoria->nome ?? null;
                    $item->user_cidade = $item->user->empresa->localidade ?? null;
                    $item->user_estado = $item->user->empresa->uf ?? null;
                }
                
                return $item;
            });

            Log::info('✅ Feed carregado:', ['total' => $portfolios->total()]);

            return response()->json($portfolios, 200);
            
        } catch (Exception $e) {
            Log::error('❌ Erro ao carregar feed:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Erro ao carregar feed'], 500);
        }
    }

    /**
     * Atualizar publicação
     */
    public function update(Request $request, int $idPost)
    {
        try {
            $logado = Auth::guard('user')->user();
            
            if (!$logado) {
                return response()->json(['message' => 'Usuário não autenticado'], 401);
            }
            
            $post = Portfolio::with(['fotos', 'videos'])->findOrFail($idPost);
            
            if ($post->user_id !== $logado->id) {
                return response()->json(['message' => 'Este post não pertence a você'], 403);
            }
            
            $validated = $request->validate([
                'titulo' => 'nullable|string|max:255',
                'descricao' => 'nullable|string',
                'imagens' => 'nullable|array',
                'imagens.*' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
                'videos' => 'nullable|array',
                'videos.*' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:10240',
            ]);
            
            // Atualizar título e descrição
            if ($request->has('titulo')) {
                $post->titulo = $validated['titulo'];
            }
            
            if ($request->has('descricao')) {
                $post->descricao = $validated['descricao'];
            }
            
            $post->save();
            
            // Atualizar imagens
            if ($request->hasFile('imagens')) {
                // Deletar imagens antigas
                foreach ($post->fotos as $foto) {
                    Storage::disk('public')->delete($foto->caminho);
                    $foto->delete();
                }
                
                // Adicionar novas imagens
                foreach ($request->file('imagens') as $imagem) {
                    $imagem_path = $imagem->store('portfolio/fotos', 'public');
                    
                    Foto::create([
                        'caminho' => $imagem_path,
                        'portfolio_id' => $post->id,
                    ]);
                }
            }
            
            // Atualizar vídeos
            if ($request->hasFile('videos')) {
                // Deletar vídeos antigos
                foreach ($post->videos as $video) {
                    Storage::disk('public')->delete($video->caminho);
                    $video->delete();
                }
                
                // Adicionar novos vídeos
                foreach ($request->file('videos') as $video) {
                    $video_path = $video->store('portfolio/videos', 'public');
                    
                    Video::create([
                        'caminho' => $video_path,
                        'portfolio_id' => $post->id,
                    ]);
                }
            }
            
            $post->load(['fotos', 'videos']);
            
            return response()->json([
                'message' => 'Publicação atualizada com sucesso',
                'data' => $post,
            ], 200);
            
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            Log::error('Erro ao atualizar publicação', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao atualizar publicação'], 500);
        }
    }

    /**
     * Deletar publicação
     */
    public function destroy(int $id)
    {
        try {
            $logado = Auth::guard('user')->user();
            $portfolio = Portfolio::findOrFail($id);
            
            if ($portfolio->user_id !== $logado->id) {
                return response()->json(['message' => 'Você não tem permissão para deletar esta publicação'], 403);
            }
            
            // Deletar arquivos físicos
            foreach ($portfolio->fotos as $foto) {
                Storage::disk('public')->delete($foto->caminho);
            }
            
            foreach ($portfolio->videos as $video) {
                Storage::disk('public')->delete($video->caminho);
            }
            
            // Deletar registros do banco
            $portfolio->delete();
            
            return response()->json([
                'message' => 'Publicação deletada com sucesso'
            ], 200);
            
        } catch (Exception $e) {
            Log::error('Erro ao deletar publicação', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Erro ao deletar publicação'], 500);
        }
    }
}