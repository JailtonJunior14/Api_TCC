<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use App\Models\Empresa;
use App\Models\Prestador;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        try {
        }catch(ValidationException $e){
            Log::error('ta errado algo', ['error' => $e->getMessage()]);
        }
        catch(QueryException $e){
            Log::error('deu errado bd', ['error' => $e->getMessage()]);
        } 
        catch (Exception $e) {
            Log::error('deu errado', ['error' => $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
