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
        $request->validate(['cpf' => 'required|unique:contratante,cpf',]);
    }
    public function check_cpf_prestador(Request $request){
        $request->validate(['cpf' => 'required|unique:prestador,cpf',]);
    }



    public function check_cnpj(Request $request){
        $request->validate(['cnpj' => 'required|empresa,cnpj',]);    
    }
    public function check_numero(Request $request){
        $request->validate([]);
    }
    public function check_razaoSocial(Request $request){
        $request->validate(['razao_social' => 'required|unique:empresa,razao_social',]); 
    }
}
