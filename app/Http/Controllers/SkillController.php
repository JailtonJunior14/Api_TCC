<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(int $id){
        $skills = Skill::where('id_ramo', $id)->get();

        // dd($skills);
        return response()->json($skills);
    }
}
