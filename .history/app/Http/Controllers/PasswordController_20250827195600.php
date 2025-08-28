<?php

namespace App\Http\Controllers;

use App\Models\Password_reset;
use App\Models\Prestador;
use App\Notifications\PasswordRequest;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class PasswordController extends Controller
{
    public function forgot_password (Request $request){
        try
        {
            $request->validate([
            'email' => 'required|email'
            ]);

            $code = mt_rand(100000,999999);

            // dd($code);

            Password_reset::updateOrCreate(
                ['email' => $request->email],

                ['code' => $code, 'expires_at' => now()->addMinutes(10)]
            );

            $prestador = Prestador::where('email', $request->email)->first();
            $empresa = Prestador::where('email', $request->email)->first();
            $contratante = Prestador::where('email', $request->email)->first();
            //dd($user);

            if($prestador){
                $user->notify(new PasswordRequest($code));
                //return response()->json('eu existo');
            }

            return response()->json(['message' => 'Código enviado para o e-mail.'], Response::HTTP_OK);



        } catch(Exception $e){
            Log::error('deu errado', [$e->getMessage()]);
        }
    }

    public function verificar_code(Request $request){

        try {
            $request->validate([
            'email'=> 'required|email',
            'code' => 'required'
            ]);

            $codigo = Password_reset::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())->first();

            if ($codigo) {
                return response()->json([
                    'status' => 'ok'
                ], 200);
            }


        } catch (Exception $e) {
            Log::error('deu errado', [$e->getMessage()]);
        }
        


    }

    public function atualizar_senha(Request $request){
        try {
            $request->validate([
            'email'=> 'required|email',
            'code' => 'required',
            'password' => 'required'
            ]);

            $codigo = Password_reset::where('email', $request->email)
            ->where('code', $request->code)
            ->where('expires_at', '>', now())->first();

            if ($codigo) {
                $user = Prestador::where('email', $request->email)->first();

                if($user){
                    if ($request->has('password')){
                        $user->password = Hash::make($request['password']);

                        //dd($user);
                        $user->save();
                    }
                }

                elseif(!$user){
                    return response()->json([
                        'message' => 'algo de errado',
                    ]);
                }
            }


        }catch(QueryException $e){
            Log::error('deu merda bd', [$e->getMessage()]);
        }
        catch (Exception $e) {
            Log::error('deu errado', [$e->getMessage()]);
        }
    }
}
