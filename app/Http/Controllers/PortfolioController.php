<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Portfolio;
use App\Models\Video;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PortfolioController extends Controller
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
    public function store(Request $request)
    {
        try {
            $logado = Auth::guard('user')->user();
            // dd($logado->id);
            $request->validate([
                'imagens' => 'nullable|array',
                'imagens.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'videos' => 'nullable|array',
                'videos.*' => 'nullable|file|mimetypes:video/mp4',
                'descricao' => 'required|string',
            ]);


            $portfolio = new Portfolio();

            $portfolio->user_id = $logado->id;
            $portfolio->descricao = $request['descricao'];
            $portfolio->save();

            // dd($request->videos);

            if($request->hasFile('imagens')){
                foreach ($request->file('imagens') as $imagem) {
                    $imagem_path = $imagem->store('fotos/portfolio', 'public');
                    $portfolio->imagens()->create([
                        'foto' => $imagem_path
                    ]);
                }
            }
            if($request->hasFile('videos')){
                foreach ($request->file('videos') as $videos) {
                    $video_path = $videos->store('fotos/portfolio', 'public');
                    $portfolio->videos()->create([
                        'video' => $video_path
                    ]);
                }
            }



        } catch (ValidationException $e) {
            Log::error('erro de validação', ['error' => $e->getMessage()]);
        } catch (QueryException $e){
            Log::error('erro de banco', ['error' => $e->getMessage()]);
        } catch(Exception $e){
            Log::error('erro', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Portfolio $portfolio)
    {
        $logado = Auth::guard('user')->user();
        $portfolio = Portfolio::where('user_id', $logado->id)->first();
        // dd($portfolio);

        return response()->json([
            'descricao' => $portfolio->descricao,
            'imagem' => asset(Storage::url($portfolio->imagem)),
            'video' => asset(Storage::url($portfolio->video)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
