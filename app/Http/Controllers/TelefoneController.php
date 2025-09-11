<?php

namespace App\Http\Controllers;

use App\Models\Telefone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TelefoneController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate([
            'telefone' => 'required|string',
        ]);

        $user = Auth::guard('user')->user();
        $id = $user->id;
        // dd($id);

        $telefone = new Telefone();
        $telefone->user_id = $id;
        $telefone->telefone = $request->telefone;
        $telefone->save();
        } catch (ValidationException $e) {
            Log::error('validação', ['erro', $e->getMessage()]);
        }
    }
}
