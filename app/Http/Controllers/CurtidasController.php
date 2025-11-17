<?php

namespace App\Http\Controllers;

use App\Models\Curtidas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CurtidasController extends Controller
{
    public function curtir($perfilId){
        $userId = Auth::id();
        $logado = Auth::user();

        if($userId == $perfilId)
            return response()->json(['message' => 'Não pode curtir a si mesmo']);


        if (Curtidas::jaCurtiu($userId, $perfilId)) {
            return response()->json(['error' => 'Você já curtiu este perfil.'], 400);
        }

        // Criar a nova curtida
        Curtidas::create([
            'user_id' => $userId,
            'perfil_id' => $perfilId,
        ]);

        return response()->json([
            'message' => 'Perfil curtido com sucesso!',
            'total de perfis curtidos' => $logado->curtidasQueEuDei->count()
        ]);
    }

    public function descurtir($perfilId)
    {
        $userId = Auth::id();

        Curtidas::where('user_id', $userId)
               ->where('perfil_id', $perfilId)
               ->delete();

        return response()->json(['message' => 'Você descurtiu este perfil.']);
    }

    public function verificarCurtida($perfilId)
    {
        $userId = Auth::id();

        $jaCurtiu = Curtidas::jaCurtiu($userId, $perfilId);

        return response()->json([
            'curtido' => $jaCurtiu,
        ]);
    }

    public function contarCurtidasAuth(){
        $user = Auth::user();

        $curtidas = $user->curtidasQueEuDei
            ->with(['prestador', 'empresa'])
            ->get();

        $curtidas = $curtidas->map(function ($userCurtido) {
            if ($userCurtido->type === 'prestador') {
                $userCurtido->makeHidden(['empresa']);
            } else {
                $userCurtido->makeHidden(['prestador']);
            }
            return $userCurtido;
        });

        return response()->json([
            'Curtidas que dei' => $curtidas,
            'Curtidas que recebi' => $user->curtidasQueRecebi->count()
        ]);

    }

    public function contarCurtidasUser(){

    }
        
}

