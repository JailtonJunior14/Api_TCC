<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use App\Models\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidationController extends Controller
{
    public function check_email(Request $request){
       try
       {
        $validado = Validator::make($request->all(),
        [

            'valor' => 'email|unique:users,email',
            ],
            [
                'valor.unique' => 'email já está sendo usado!'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => $validado->errors(),
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('email', [$e->getMessage()]);
        }
    }
    public function check_cpf(Request $request){
        $validator = Validator::make($request->all(), [
            'valor' => [
                'required',
                function ($atributo, $value, $fails){
                    $contratante = Contratante::where('cpf', $value)->exists();
                    $prestador = Prestador::where('cpf', $value)->exists();

                    // dd($value);
                    // dd($value);
                    
                    if($prestador || $contratante){
                        $fails($atributo . ' usado');
                        // dd($prestador);
                    }
                }
            ],
        ]);
        

        if ($validator->fails()) {
            $erro = $validator->errors()->toArray();

            Log::error('erro validator', [
                'error' => $erro,
                'dados' => $request->all(),
            ]);
            throw new ValidationException($validator);
        }
    }

    public function check_cnpj(Request $request){
        // $request->validate(['cnpj' => 'required|empresa,cnpj',]);
        
         try
       {
        $validado = Validator::make($request->all(),
        [

            'valor' => 'required|unique:empresa,cnpj',
            ],
            [
                'valor.unique' => 'cnpj já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'cnpj usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('cnpj', [$e->getMessage()]);
        }
    }
    public function check_numero(Request $request){
        try
       {
        $validado = Validator::make($request->all(),
        [

            'valor' => 'required|unique:telefone,telefone',
            ],
            [
                'valor.unique' => 'numero já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'numero usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('email', [$e->getMessage()]);
        }
    }
    public function check_razaoSocial(Request $request){

        try
       {
        $validado = Validator::make($request->all(),
        [

            'valor' => 'required|unique:empresa,razao_social',
            ],
            [
                'valor.unique' => 'razao_social já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'razao_social usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('razao_social', [$e->getMessage()]);
        }
    }
}
