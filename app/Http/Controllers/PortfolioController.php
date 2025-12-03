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
     * Criar nova publicação
     */
    public function store(Request $request)
{
    try {
        $logado = Auth::guard('user')->user();
        
        if (!$logado) {
            Log::error('❌ Usuário não autenticado');
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }
        
        Log::info('📤 Dados recebidos:', [
            'user_id' => $logado->id,
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
        ]);
        
        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'descricao' => 'required|string',
            'imagens' => 'nullable|array',
            'imagens.*' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:10240',
        ]);
        
        $portfolio = Portfolio::create([
            'user_id' => $logado->id,
            'titulo' => $validated['titulo'] ?? null,
            'descricao' => $validated['descricao'],
        ]);
        
        // Salvar imagens
        if ($request->hasFile('imagens')) {
            foreach ($request->file('imagens') as $imagem) {
                $imagem_path = $imagem->store('fotos/portfolio', 'public');
                
                Foto::create([
                    'foto' => $imagem_path,
                    'portfolio_id' => $portfolio->id,
                ]);
            }
        }
        
        // Salvar vídeos
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $video_path = $video->store('videos/portfolio', 'public');
                
                Video::create([
                    'caminho' => $video_path,
                    'portfolio_id' => $portfolio->id,
                ]);
            }
        }
        
        // ✅ CARREGAR e MAPEAR as fotos/vídeos antes de retornar
        $portfolio->load(['fotos', 'videos']);
        
        // ✅ MAPEAR fotos com URL completa
        $portfolio->fotos = $portfolio->fotos->map(function($foto) {
            return [
                'id' => $foto->id,
                'foto' => $foto->foto,
                'portfolio_id' => $foto->portfolio_id,
                'caminho' => url('storage/' . $foto->foto), // ✅ URL completa
                'url' => url('storage/' . $foto->foto), // ✅ URL completa
                'created_at' => $foto->created_at,
                'updated_at' => $foto->updated_at
            ];
        });
        
        // ✅ MAPEAR vídeos com URL completa
        $portfolio->videos = $portfolio->videos->map(function($video) {
            return [
                'id' => $video->id,
                'portfolio_id' => $video->portfolio_id,
                'caminho' => url('storage/' . $video->caminho), // ✅ URL completa
                'url' => url('storage/' . $video->caminho), // ✅ URL completa
                'created_at' => $video->created_at,
                'updated_at' => $video->updated_at
            ];
        });
        
        return response()->json([
            'message' => 'Publicação criada com sucesso',
            'data' => $portfolio,
        ], 201);
        
    } catch (ValidationException $e) {
        return response()->json(['message' => 'Erro de validação', 'errors' => $e->errors()], 422);
    } catch (Exception $e) {
        Log::error('❌ Erro ao criar publicação:', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Erro ao criar publicação', 'error' => $e->getMessage()], 500);
    }
}
    /**
     * ✅ MÉTODO SHOW CORRIGIDO - Lista feed com fotos
     */
    public function show()
    {
        try {
            $logado = Auth::guard('user')->user();
            
            if (!$logado) {
                return response()->json(['message' => 'Não autenticado'], 401);
            }
            
            Log::info('📡 Carregando feed para usuário:', ['user_id' => $logado->id]);
            
            // ✅ EAGER LOADING correto
            $portfolios = Portfolio::with([
                    'user.prestador.ramo',
                    'user.empresa.categoria',
                    'fotos', // ✅ Certifique-se que está carregando
                    'videos'
                ])
                ->where('user_id', '!=', $logado->id)
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('📊 Total de portfolios antes de mapear:', ['total' => $portfolios->count()]);

            $portfolios = $portfolios->map(function ($item) {
                $tipo = $item->user->type ?? null;
                
                // Avaliações
                $avaliacoes = \App\Models\Avaliacao::where('alvo_id', $item->user->id)->get();
                $media = $avaliacoes->count() > 0 ? $avaliacoes->avg('estrelas') : 0;
                $total = $avaliacoes->count();
                
                $item->user->avaliacao = [
                    'media' => round($media, 1),
                    'total' => $total
                ];
                
                $item->user->tipo_conta = $tipo;
                
                // Dados do usuário
                if ($tipo === 'prestador' && $item->user->prestador) {
                    $item->user_nome = $item->user->prestador->nome;
                    $item->user_foto = $item->user->prestador->foto 
                        ? url('storage/' . $item->user->prestador->foto) 
                        : null;
                    $item->user_ramo = $item->user->prestador->ramo->nome ?? 'Sem categoria';
                    
                } elseif ($tipo === 'empresa' && $item->user->empresa) {
                    $item->user_nome = $item->user->empresa->razao_social;
                    $item->user_foto = $item->user->empresa->foto 
                        ? url('storage/' . $item->user->empresa->foto) 
                        : null;
                    $item->user_ramo = $item->user->empresa->categoria->nome ?? 'Sem categoria';
                }
                
                // ✅ DEBUG: Log das fotos ANTES de mapear
                Log::info('🖼️ Fotos do portfolio ' . $item->id . ':', [
                    'total_fotos' => $item->fotos->count(),
                    'fotos' => $item->fotos->toArray()
                ]);
                
                // ✅ MAPEAR FOTOS corretamente
                $item->fotos = $item->fotos->map(function($foto) {
                    $url = url('storage/' . $foto->foto);
                    Log::info('📸 Foto mapeada:', ['id' => $foto->id, 'campo_foto' => $foto->foto, 'url_final' => $url]);
                    
                    return [
                        'id' => $foto->id,
                        'portfolio_id' => $foto->portfolio_id,
                        'caminho' => $url, // ✅ Campo que o frontend espera
                        'url' => $url,
                        'created_at' => $foto->created_at,
                        'updated_at' => $foto->updated_at
                    ];
                });
                
                // Videos
                $item->videos = $item->videos->map(function($video) {
                    return [
                        'id' => $video->id,
                        'portfolio_id' => $video->portfolio_id,
                        'caminho' => url('storage/' . $video->caminho),
                        'url' => url('storage/' . $video->caminho),
                        'created_at' => $video->created_at,
                        'updated_at' => $video->updated_at
                    ];
                });
                
                return $item;
            });

            Log::info('✅ Feed carregado:', ['total' => $portfolios->count()]);

            return response()->json(['data' => $portfolios], 200);
            
        } catch (Exception $e) {
            Log::error('❌ Erro ao carregar feed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Erro ao carregar feed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar publicação específica
     */
    public function selectId(int $id)
    {
        try {
            $portfolio = Portfolio::with(['fotos', 'videos', 'user.prestador.ramo', 'user.empresa.categoria'])
                ->findOrFail($id);

            $avaliacoes = \App\Models\Avaliacao::where('alvo_id', $portfolio->user->id)->get();
            $media = $avaliacoes->count() > 0 ? $avaliacoes->avg('estrelas') : 0;
            $total = $avaliacoes->count();
            
            $portfolio->user->avaliacao = ['media' => round($media, 1), 'total' => $total];
            $portfolio->user->tipo_conta = $portfolio->user->type;
            
            $portfolio->fotos = $portfolio->fotos->map(function($foto) {
                return [
                    'id' => $foto->id,
                    'portfolio_id' => $foto->portfolio_id,
                    'caminho' => url('storage/' . $foto->foto),
                    'url' => url('storage/' . $foto->foto),
                    'created_at' => $foto->created_at,
                    'updated_at' => $foto->updated_at
                ];
            });
            
            $portfolio->videos = $portfolio->videos->map(function($video) {
                return [
                    'id' => $video->id,
                    'portfolio_id' => $video->portfolio_id,
                    'caminho' => url('storage/' . $video->caminho),
                    'url' => url('storage/' . $video->caminho),
                    'created_at' => $video->created_at,
                    'updated_at' => $video->updated_at
                ];
            });

            return response()->json(['data' => $portfolio]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Publicação não encontrada'], 404);
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
                ->get()
                ->map(function($item) {
                    $item->fotos = $item->fotos->map(function($foto) {
                        return [
                            'id' => $foto->id,
                            'portfolio_id' => $foto->portfolio_id,
                            'caminho' => url('storage/' . $foto->foto),
                            'url' => url('storage/' . $foto->foto),
                            'created_at' => $foto->created_at,
                            'updated_at' => $foto->updated_at
                        ];
                    });
                    
                    $item->videos = $item->videos->map(function($video) {
                        return [
                            'id' => $video->id,
                            'portfolio_id' => $video->portfolio_id,
                            'caminho' => url('storage/' . $video->caminho),
                            'url' => url('storage/' . $video->caminho),
                            'created_at' => $video->created_at,
                            'updated_at' => $video->updated_at
                        ];
                    });
                    
                    return $item;
                });

            return response()->json(['data' => $portfolios]);
        } catch (Exception $e) {
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
                ->get()
                ->map(function($item) {
                    $item->fotos = $item->fotos->map(function($foto) {
                        return [
                            'id' => $foto->id,
                            'portfolio_id' => $foto->portfolio_id,
                            'caminho' => url('storage/' . $foto->foto),
                            'url' => url('storage/' . $foto->foto),
                            'created_at' => $foto->created_at,
                            'updated_at' => $foto->updated_at
                        ];
                    });
                    
                    $item->videos = $item->videos->map(function($video) {
                        return [
                            'id' => $video->id,
                            'portfolio_id' => $video->portfolio_id,
                            'caminho' => url('storage/' . $video->caminho),
                            'url' => url('storage/' . $video->caminho),
                            'created_at' => $video->created_at,
                            'updated_at' => $video->updated_at
                        ];
                    });
                    
                    return $item;
                });

            return response()->json(['data' => $portfolios]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao carregar publicações'], 500);
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
            
            if ($request->has('titulo')) $post->titulo = $validated['titulo'];
            if ($request->has('descricao')) $post->descricao = $validated['descricao'];
            
            $post->save();
            
            // Atualizar imagens
            if ($request->hasFile('imagens')) {
                foreach ($post->fotos as $foto) {
                    Storage::disk('public')->delete($foto->foto);
                    $foto->delete();
                }
                
                foreach ($request->file('imagens') as $imagem) {
                    $imagem_path = $imagem->store('fotos/portfolio', 'public');
                    
                    Foto::create([
                        'foto' => $imagem_path,
                        'portfolio_id' => $post->id,
                    ]);
                }
            }
            
            // Atualizar vídeos
            if ($request->hasFile('videos')) {
                foreach ($post->videos as $video) {
                    Storage::disk('public')->delete($video->caminho);
                    $video->delete();
                }
                
                foreach ($request->file('videos') as $video) {
                    $video_path = $video->store('videos/portfolio', 'public');
                    
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
            
        } catch (Exception $e) {
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
                return response()->json(['message' => 'Você não tem permissão'], 403);
            }
            
            foreach ($portfolio->fotos as $foto) {
                Storage::disk('public')->delete($foto->foto);
            }
            
            foreach ($portfolio->videos as $video) {
                Storage::disk('public')->delete($video->caminho);
            }
            
            $portfolio->delete();
            
            return response()->json(['message' => 'Publicação deletada com sucesso'], 200);
            
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao deletar publicação'], 500);
        }
    }
}