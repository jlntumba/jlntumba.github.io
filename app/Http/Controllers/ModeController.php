<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Http\Requests\StoreModeRequest;
use App\Http\Requests\UpdateModeRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Panier;
use App\Models\PanierMac;
use Illuminate\Support\Facades\Storage;

class ModeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modes=Mode::all();
        $cpt=1;
        return view('modes.index',compact('modes','cpt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("modes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeRequest $request)
    {
        $this->validate($request,[
            'mode'=>['required','string','max:255','unique:modes,mode,except,id']
        ]);

        Mode::create([
            'mode'=>$request->mode,
        ]);

        return redirect()->route('modes.index');
    }
    /**
     * Ajout d'une mode par popup modal : create article
     */
    public function addMode(){
        $this->validate(request(),[
            'mode'=>['required','string','max:255','unique:modes,mode,except,id']
        ]);

        Mode::create([
            'mode'=>request('mode'),
        ]);

        return redirect()->route('articles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function show(Mode $mode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function edit(Mode $mode)
    {
        return view("modes.edit",compact('mode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeRequest  $request
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModeRequest $request, Mode $mode)
    {
        $this->validate($request,[
            'mode'=>['required','string','max:255']
        ]);

        if (($mode->mode!=$request->mode)) {
            $this->validate($request,[
                'mode'=>['required','string','max:255','unique:modes,mode,except,id']
            ]);
        } 

        $mode->mode = $request->mode;
        $mode->save();

        return redirect()->route('modes.index');
    }
    /**
     * Ajout d'une mode par popup modal : create article
     */
    public function addModeU(Article $article){
        $this->validate(request(),[
            'mode'=>['required','string','max:255','unique:modes,mode,except,id']
        ]);

        Mode::create([
            'mode'=>request('mode'),
        ]);

        return redirect()->route('articles.edit',$article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mode  $mode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mode $mode)
    {
        $articles = $mode->articles();

        foreach ($articles as $article) {
            $disk = Storage::build([
                'driver'=>'local',
                'root'=>storage_path('app\public\images'),
            ]);
    
            $list = $disk->directories();
    
            foreach ($list as $item) {
                if($item==$article->nom.$article->id){
                    $disk->deleteDirectory($item);
                    break;
                }
            }
    
            ArticleTaille::where('article_id',$article->id)->delete();
            PanierMac::where('article_id',$article->id)->delete();
            Panier::where('article_id',$article->id)->delete();
    
            $article->delete();
        }

        $mode->delete();
        return redirect()->route('modes.index');
    }
}
