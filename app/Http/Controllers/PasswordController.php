<?php

namespace App\Http\Controllers;

use App\Models\Password_reset;
use App\Models\User;
use App\Notifications\PasswordRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    public function forgot_password(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);
            // dd($request->all());
            $user = User::where('email', $request->email)->first();
            // dd($user);

            // dd($user);

            if ($user) {
                $code = mt_rand(100000, 999999);

                // dd($code);

                $pass = Password_reset::updateOrCreate(
                    ['email' => $request->email],

                    ['code' => $code, 'expires_at' => now()->addMinutes(10)]
                );
                // dd($pass);

                Log::info('ta enviando');
                $user->notify(new PasswordRequest($code));
                Log::info('enviou');
                // return response()->json('eu existo');
                // dd($not);

            } else {
                return response()->json([
                    'message' => 'Usuario não encontrado',
                ]);
            }

            return response()->json(['message' => 'Código enviado para o e-mail.'], Response::HTTP_OK);

        } catch (Exception $e) {
            Log::error('deu errado', [$e->getMessage()]);
            response()->json([
                'erro' => $e->getMessage(),
            ], 500);
        }
    }

    public function verificar_code(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
                'code' => 'required',
            ]);

            $codigo = Password_reset::where('email', $request->email)
                ->where('code', $request->code)
                ->where('expires_at', '>', now())->first();

            if ($codigo) {
                return response()->json([
                    'status' => 'ok',
                ], 200);
            }

        } catch (Exception $e) {
            Log::error('deu errado', [$e->getMessage()]);
        }

    }

    public function atualizar_senha(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'code' => 'required',
                'password' => 'required',
            ]);

            $codigo = Password_reset::where('email', $request->email)
                ->where('code', $request->code)
                ->where('expires_at', '>', now())->first();
            // dd($codigo);

            if ($codigo) {

                $user = User::where('email', $request->email)->first();

                if ($user) {
                    if ($request->has('password')) {
                        $user->password = Hash::make($request['password']);

                        // dd($user);
                        $user->save();

                        return response()->json([
                            'message' => 'Senha atualizada com sucesso',
                        ], 200);
                    }
                } else {
                    response()->json([
                        'message' => 'deu ruim em salvar',
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'não existe o codigo',
                ]);
            }

        } catch (QueryException $e) {
            Log::error('deu merda bd', [$e->getMessage()]);
        } catch (Exception $e) {
            Log::error('deu errado', [$e->getMessage()]);
        }
    }
}
