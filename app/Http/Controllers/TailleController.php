<?php

namespace App\Http\Controllers;

use App\Models\Taille;
use App\Http\Requests\StoreTailleRequest;
use App\Http\Requests\UpdateTailleRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Couleur;
use App\Models\Panier;
use App\Models\PanierMac;
use Illuminate\Support\Facades\Storage;

class TailleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tailles=Taille::all();
        $cpt = 1;
        return view('tailles.index',compact('tailles','cpt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("tailles.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTailleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTailleRequest $request)
    {
        $this->validate($request,[
            'taille'=>['required','string','max:255','unique:tailles,taille,except,id'],
            'description'=>['required','string']
        ]);

        //dd($request->description);

        Taille::insert([
            ['taille'=>$request->taille,'description'=>$request->description]
        ]);

        return redirect()->route('tailles.index');
    }
    /**
     * Ajout d'une taille par popup modal : create article
     */
    public function addTaille(){
        $this->validate(request(),[
            'taille'=>['required','string','max:255','unique:tailles,taille,except,id'],
            'descript'=>['required','string']
        ]);

        //dd($request->description);

        Taille::insert([
            ['taille'=>request('taille'),'description'=>request('descript')]
        ]);

        return redirect()->route('articles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Taille  $taille
     * @return \Illuminate\Http\Response
     */
    public function show(Taille $taille)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Taille  $taille
     * @return \Illuminate\Http\Response
     */
    public function edit(Taille $taille)
    {
        return view("tailles.edit",compact('taille'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTailleRequest  $request
     * @param  \App\Models\Taille  $taille
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTailleRequest $request, Taille $taille)
    {
        $this->validate($request,[
            'taille'=>['required','string','max:255'],
            'description'=>['required','string'],
        ]);

        if (($taille->taille!=$request->taille)) {
            $this->validate($request,[
                'taille'=>['required','string','max:255','unique:tailles,taille,except,id']
            ]);
        } 

        $taille->taille = $request->taille;
        $taille->description = $request->description;
        $taille->save();

        return redirect()->route('tailles.index');
    }

    /**
     * Ajout d'une taille par popup modal : create article
     */
    public function addTailleU(Article $article){
        $this->validate(request(),[
            'taille'=>['required','string','max:255','unique:tailles,taille,except,id'],
            'descript'=>['required','string']
        ]);

        //dd($request->description);

        Taille::insert([
            ['taille'=>request('taille'),'description'=>request('descript')]
        ]);
        
        return redirect()->route('articles.edit',$article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taille  $taille
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taille $taille)
    {
        $articles = $taille->articles();

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

        $taille->delete();
        return redirect()->route('tailles.index');
    }
}
