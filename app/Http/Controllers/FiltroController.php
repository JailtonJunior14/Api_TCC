<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\Request;

class FiltroController extends Controller
{
    public function filtro(Request $request)
    {
        // --- Se tiver período, retorna POSTS ---
        if ($request->filled('periodo')) {

            $dataInicio = match ($request->periodo) {
                '24h' => now()->subDay(),
                '7d'  => now()->subDays(7),
                '30d' => now()->subDays(30),
                default => null,
            };

            $posts = Portfolio::query()
                ->with([
                    'user:id,email,type',
                    'fotos:id,portfolio_id,foto',
                    'videos:id,portfolio_id,video'
                ])
                ->when($dataInicio, function ($q) use ($dataInicio) {
                    $q->where('created_at', '>=', $dataInicio);
                })
                ->when(
                    $request->periodo === 'personalizado' &&
                    $request->filled(['inicio', 'fim']),
                    function ($q) use ($request) {
                        $q->whereBetween('created_at', [$request->inicio, $request->fim]);
                    }
                )
                ->when($request->filled('segmento'), function ($q) use ($request) {
                    // filtra posts por tipo de usuário (prestador/empresa)
                    $q->whereHas('user', fn($u) => $u->where('type', $request->segmento));
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'tipo' => 'posts',
                'data' => $posts
            ]);
        }

        // --- Caso contrário, retorna USUÁRIOS ---
        $usuarios = User::query()
            ->when($request->filled('segmento'), function ($q) use ($request) {
                $q->where('type', $request->segmento);
            })
            ->when($request->filled('curtida_min') && $request->filled('curtida_max'), function ($q) use ($request) {
                $q->whereBetween('curtidas', [$request->curtida_min, $request->curtida_max]);
            })
            ->when($request->filled('avaliacao_min'), function ($q) use ($request) {
                $q->whereHas('avaliacoes', fn($a) => $a->where('estrelas', '>=', $request->avaliacao_min));
            })
            ->withAvg('avaliacoes', 'estrelas')
            ->withCount('portfolios')
            ->paginate(10);

        return response()->json([
            'tipo' => 'usuarios',
            'data' => $usuarios
        ]);
    }
}
