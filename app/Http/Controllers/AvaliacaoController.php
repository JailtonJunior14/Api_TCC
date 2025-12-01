<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Avaliacao::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $logado = Auth::guard('user')->user();
            $request->validate([
                'comentario' => 'nullable|string|max:255',
                'estrelas' => 'required|numeric|min:1|max:5',
                'alvo_id' => 'required|integer|exists:users,id',
            ]);
            
            // Verificar se já avaliou
            $avaliacaoExistente = Avaliacao::where('user_id', $logado->id)
                ->where('alvo_id', $request->alvo_id)
                ->first();
            
            if ($avaliacaoExistente) {
                return response()->json([
                    'message' => 'Você já avaliou este usuário',
                ], 400);
            }
            
            $avaliacao = new Avaliacao;
            $avaliacao->user_id = $logado->id;
            $avaliacao->comentario = $request->comentario;
            $avaliacao->estrelas = $request->estrelas;
            $avaliacao->alvo_id = $request->alvo_id;
            $avaliacao->save();

            // Recalcular média
            $media = Avaliacao::where('alvo_id', $request->alvo_id)
                ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                ->first();

            return response()->json([
                'message' => 'Avaliação cadastrada com sucesso!',
                'avaliacao' => [
                    'id' => $avaliacao->id,
                    'comentario' => $avaliacao->comentario,
                    'estrelas' => $avaliacao->estrelas,
                ],
                'estatisticas' => [
                    'media' => round($media->media, 1),
                    'total' => $media->total,
                ]
            ], 201);
        } catch (ValidationException $e) {
            Log::error('Erro validação avaliação', [$e->getMessage()]);

            return response()->json([
                'message' => 'Erro de validação',
                'erros' => $e->errors(),
            ], 422);
        } catch (QueryException $e) {
            Log::error('Erro banco avaliação', [$e->getMessage()]);

            return response()->json([
                'message' => 'Erro no banco de dados',
                'erro' => $e->getMessage(),
            ], 500);
        } catch (Exception $e) {
            Log::error('Erro inesperado avaliação', [$e->getMessage()]);

            return response()->json([
                'message' => 'Erro inesperado',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource - Busca avaliação de um usuário específico
     */
    public function show($id)
    {
        try {
            $avaliacao = Avaliacao::where('alvo_id', $id)
                ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                ->first();

            // Distribuição de estrelas
            $distribuicao = Avaliacao::where('alvo_id', $id)
                ->selectRaw('estrelas, COUNT(*) as count')
                ->groupBy('estrelas')
                ->get()
                ->keyBy('estrelas');

            $totalAvaliacoes = $avaliacao->total;
            $distribuicaoCompleta = [];
            
            for ($i = 5; $i >= 1; $i--) {
                $count = $distribuicao->get($i)?->count ?? 0;
                $porcentagem = $totalAvaliacoes > 0 ? round(($count / $totalAvaliacoes) * 100) : 0;
                
                $distribuicaoCompleta[] = [
                    'estrelas' => $i,
                    'count' => $count,
                    'porcentagem' => $porcentagem
                ];
            }

            return response()->json([
                'media' => $avaliacao->media ? round($avaliacao->media, 1) : 0,
                'total' => $avaliacao->total ?? 0,
                'distribuicao' => $distribuicaoCompleta
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao buscar avaliação', [$e->getMessage()]);
            
            return response()->json([
                'message' => 'Erro ao buscar avaliação',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Busca avaliações do usuário autenticado
     */
    public function minhasAvaliacoes()
    {
        try {
            $logado = Auth::guard('user')->user();
            $avaliacao = Avaliacao::where('alvo_id', $logado->id)
                ->selectRaw('AVG(estrelas) as media, COUNT(*) as total')
                ->first();

            return response()->json([
                'media' => $avaliacao->media ? round($avaliacao->media, 1) : 0,
                'total' => $avaliacao->total ?? 0,
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao buscar minhas avaliações', [$e->getMessage()]);
            
            return response()->json([
                'message' => 'Erro ao buscar avaliações',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lista todas as avaliações de um usuário específico
     */
    public function listarAvaliacoes($id)
    {
        try {
            $avaliacoes = Avaliacao::where('alvo_id', $id)
                ->with('user:id,email') // Carrega info do avaliador
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'avaliacoes' => $avaliacoes
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao listar avaliações', [$e->getMessage()]);
            
            return response()->json([
                'message' => 'Erro ao listar avaliações',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $logado = Auth::guard('user')->user();
            
            $avaliacao = Avaliacao::where('id', $id)
                ->where('user_id', $logado->id)
                ->first();
            
            if (!$avaliacao) {
                return response()->json([
                    'message' => 'Avaliação não encontrada ou você não tem permissão'
                ], 404);
            }
            
            $request->validate([
                'comentario' => 'nullable|string|max:255',
                'estrelas' => 'required|numeric|min:1|max:5',
            ]);
            
            $avaliacao->comentario = $request->comentario;
            $avaliacao->estrelas = $request->estrelas;
            $avaliacao->save();
            
            return response()->json([
                'message' => 'Avaliação atualizada com sucesso!',
                'avaliacao' => $avaliacao
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao atualizar avaliação', [$e->getMessage()]);
            
            return response()->json([
                'message' => 'Erro ao atualizar avaliação',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $logado = Auth::guard('user')->user();
            
            $avaliacao = Avaliacao::where('id', $id)
                ->where('user_id', $logado->id)
                ->first();
            
            if (!$avaliacao) {
                return response()->json([
                    'message' => 'Avaliação não encontrada ou você não tem permissão'
                ], 404);
            }
            
            $avaliacao->delete();
            
            return response()->json([
                'message' => 'Avaliação removida com sucesso!'
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao deletar avaliação', [$e->getMessage()]);
            
            return response()->json([
                'message' => 'Erro ao deletar avaliação',
                'erro' => $e->getMessage(),
            ], 500);
        }
    }
}