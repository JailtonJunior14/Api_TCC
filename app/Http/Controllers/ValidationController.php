<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function check_email(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);
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
