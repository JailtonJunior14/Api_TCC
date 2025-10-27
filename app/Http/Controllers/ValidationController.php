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
        return response()->json([
                'message' => [
                    'valor' => []
                ],
                'success' => true,
                'errors' => [
                    'valor' => []
                ]
            ], 200);

       }
        catch(ValidationException $e){
            Log::error('email', [$e->getMessage()]);
        }
    }
    public function check_cpf(Request $request){
        try{
            $validator = Validator::make($request->all(), [
            'valor' => [
                'required',
                function ($atributo, $value, $fail){
                    $contratante = Contratante::where('cpf', $value)->exists();
                    $prestador = Prestador::where('cpf', $value)->exists();

                    // dd($value);
                    // dd($value);
                    
                    if($prestador || $contratante){
                        $fail('CPF já está sendo usado!');
                        // dd($prestador);
                    }
                }
            ],
            ]);
        

            if ($validator->fails()) {
                return response()->json([
                    'message' => $validator->errors(),
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
             return response()->json([
                'message' => [
                    'valor' => []
                ],
                'success' => true,
                'errors' => [
                    'valor' => []
                ]
            ], 200);
    }catch(ValidationException $e){
            Log::error('cpf', [$e->getMessage()]);
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
                'message' => $validado->errors(),
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
        return response()->json([
                'message' => [
                    'valor' => []
                ],
                'success' => true,
                'errors' => [
                    'valor' => []
                ]
            ], 200);
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

            'valor' => [
                'required',
                'unique:contatos,telefone'
                
            ]
            ],
            [
                'valor.unique' => 'numero já está sendo usado',
                'valor.regex' => 'digite um telefone valido'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => $validado->errors(),
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
        return response()->json([
                'message' => [
                    'valor' => []
                ],
                'success' => true,
                'errors' => [
                    'valor' => []
                ]
            ], 200);
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
                'valor.unique' => 'razao social já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => $validado->errors(),
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
        return response()->json([
                'message' => [
                    'valor' => []
                ],
                'success' => true,
                'errors' => [
                    'valor' => []
                ]
            ], 200);
       }
        catch(ValidationException $e){
            Log::error('razao_social', [$e->getMessage()]);
        }
    }
}
