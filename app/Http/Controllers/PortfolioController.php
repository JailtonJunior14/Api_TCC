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
            // dd($request->file('videos'), $request->file('imagens'));
            $request->validate([
                'imagens' => 'nullable|array',
                'imagens.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'videos' => 'nullable|array',
                'videos.*' => 'nullable|file',
                'descricao' => 'required|string',
            ]);
            // dd($request->file('videos'), $request->file('imagens'));


            $portfolio = new Portfolio();

            $portfolio->user_id = $logado->id;
            $portfolio->descricao = $request['descricao'];
            $portfolio->save();

            // dd($request->videos);

            if($request->hasFile('imagens')){
                foreach ($request->file('imagens') as $imagem) {
                    $imagem_path = $imagem->store('fotos/portfolio', 'public');
                    $portfolio->fotos()->create([
                        'foto' => $imagem_path,
                        'portfolio_id' => $portfolio->id
                    ]);
                }
            }
            if($request->hasFile('videos')){
                foreach ($request->file('videos') as $videos) {
                    $video_path = $videos->store('fotos/portfolio', 'public');
                    $portfolio->videos()->create([
                        'video' => $video_path,
                        'portfolio_id' => $portfolio->id
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
    public function Select()
    {
        $logado = Auth::guard('user')->user();
        $portfolios = Portfolio::with(['fotos', 'videos'])
            ->where('user_id', $logado->id)->orderBy('created_at', 'desc')
            ->paginate(3);

        return response()->json($portfolios);
    }

    public function SelectIdUser(Int $id)
    {
        $portfolios = Portfolio::with(['fotos', 'videos'])
            ->where('user_id', $id)->orderBy('created_at', 'desc')
            ->paginate(3);

        // $portfolio = Portfolio::whereIn('user_id', $logado->id)->get();
        // $portfolioId = $portfolio->pluck('id');
        // // dd($portfolioId);
        // $foto = Foto::whereIn('portfolio_id', $portfolioId)->get();
        // $video = Video::whereIn('portfolio_id', $portfolioId)->get();
        // dd($portfolios->descricao);

        return response()->json([
            'portfolios' => $portfolios,
        ]);
    }


    public function SelectId(Int $id)
    {
        $portfolio = Portfolio::with(['fotos', 'videos'])->where('id', $id)->first();

        return response()->json([
            'portfolio' => $portfolio,
        ]);
    }

    public function show(){
        $portfolio = Portfolio::with(['User','fotos', 'videos'])->paginate(3);


        $portfolio->map(function($item){
            $tipo = $item->User->type ?? null;
            // dd($tipo);

            if($tipo === 'contratante'){
                $item->User->load('contratante');
                $item-> user_foto = $item->User->contratante->foto ? asset(Storage::url($item->User->contratante->foto)) : null;
                $item-> user_cidade = $item->User->contratante->localidade ?? null;
                $item-> user_estado = $item->User->contratante->estado ?? null;
                dd($item->user_foto);

            }
            elseif($tipo === 'prestador'){
                $item->User->load('prestador.ramo');
                $item-> user_foto = $item->User->prestador->foto ? asset(Storage::url($item->User->prestador->foto)) : null;
                $item-> user_ramo = $item->User->prestador->ramo->nome ?? null;
                $item-> user_cidade = $item->User->prestador->localidade ?? null;
                $item-> user_estado = $item->User->prestador->estado ?? null;
                // dd($item->user_foto);
            }
            elseif($tipo === 'empresa'){
                $item->User->load('empresa.ramo');
                $item-> user_foto = $item->User->empresa->foto ? asset(Storage::url($item->User->empresa->foto)) : null;
                $item-> user_ramo = $item->User->empresa->ramo->nome ?? null;
                $item-> user_cidade = $item->User->empresa->localidade ?? null;
                $item-> user_estado = $item->User->empresa->estado ?? null;
                dd($item->user_foto);
            }
                
            return $item;
        });
        return response()->json([
            'portfolios' => $portfolio,
        ], 200);
    }





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
