<?php

namespace App\Http\Controllers;

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

            'email' => 'email|unique:users,email',
            ],
            [
                'email.unique' => 'email já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'email usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('email', [$e->getMessage()]);
        }
    }
    public function check_cpf_contratante(Request $request){
        try
       {
        $validado = Validator::make($request->all(),
        [

            'cpf' => 'required|unique:contratante,cpf',
            ],
            [
                'cpf.unique' => 'cpg já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'cpf usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('cpf', [$e->getMessage()]);
        }
    }
    public function check_cpf_prestador(Request $request){
        try
       {
        $validado = Validator::make($request->all(),
        [

            'cpf' => 'required|unique:prestador,cpf',
            ],
            [
                'cpf.unique' => 'cpf já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'cpf usado',
                'success' => false,
                'errors' => $validado->errors()
            ], 422);
        }
       }
        catch(ValidationException $e){
            Log::error('cpf', [$e->getMessage()]);
        }
    }

    public function check_cnpj(Request $request){
        // $request->validate(['cnpj' => 'required|empresa,cnpj',]);
        
         try
       {
        $validado = Validator::make($request->all(),
        [

            'cnpj' => 'required|unique:empresa,cnpj',
            ],
            [
                'cnpj.unique' => 'cnpj já está sendo usado'
            ]);
        if($validado->fails()){
            return response()->json([
                'message' => 'cpf usado',
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

            'numero' => 'required|unique:telefone,numero',
            ],
            [
                'numero.unique' => 'numero já está sendo usado'
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

            'razao_social' => 'required|unique:empresa,razao_social',
            ],
            [
                'razao_social.unique' => 'razao_social já está sendo usado'
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
