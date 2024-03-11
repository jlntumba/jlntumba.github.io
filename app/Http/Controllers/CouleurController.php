<?php

namespace App\Http\Controllers;

use App\Models\Couleur;
use App\Http\Requests\StoreCouleurRequest;
use App\Http\Requests\UpdateCouleurRequest;
use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Panier;
use App\Models\PanierMac;
use Illuminate\Support\Facades\Storage;

class CouleurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couleurs=Couleur::all()->sortBy('couleur');
        $cpt=1;
        return view('couleurs.index',compact('couleurs','cpt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("couleurs.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCouleurRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouleurRequest $request)
    {
        $this->validate($request,[
            'couleur'=>['required','string','max:255','unique:couleurs,couleur,except,id'],
            'color'=>['required','string','max:255','unique:couleurs,color,except,id']
        ]);

        Couleur::insert([
            ['couleur'=>$request->couleur,'color'=>$request->color]
        ]);

        return redirect()->route('couleurs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Couleur  $couleur
     * @return \Illuminate\Http\Response
     */
    public function show(Couleur $couleur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Couleur  $couleur
     * @return \Illuminate\Http\Response
     */
    public function edit(Couleur $couleur)
    {
        return view("couleurs.edit",compact('couleur'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCouleurRequest  $request
     * @param  \App\Models\Couleur  $couleur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouleurRequest $request, Couleur $couleur)
    {
        $this->validate($request,[
            'couleur'=>['required','string','max:255'],
            'color'=>['required','string','max:255']
        ]);

        if (($couleur->couleur!=$request->couleur)) {
            $this->validate($request,[
                'couleur'=>['required','string','max:255','unique:couleurs,couleur,except,id']
            ]);
        } 
        if (($couleur->color!=$request->color)) {
            $this->validate($request,[
                'color'=>['required','string','max:255','unique:couleurs,color,except,id']
            ]);
        }

        $couleur->couleur = $request->couleur;
        $couleur->color = $request->color;
        $couleur->save();

        return redirect()->route('couleurs.index');
    }

    /**
     * Ajout d'une couleur par popup modal : create article
     */
    public function addCouleur(){
        $this->validate(request(),[
            'couleur'=>['required','string','max:255','unique:couleurs,couleur,except,id'],
            'color'=>['required','string','unique:couleurs,color,except,id']
        ]);

        //dd($request->description);

        Couleur::insert([
            ['couleur'=>request('couleur'),'color'=>request('color')]
        ]);

        return redirect()->route('articles.create');
    }

    

    /**
     * Ajout d'une couleur par popup modal : update article
     */
    public function addCouleurU(Article $article){
        $this->validate(request(),[
            'couleur'=>['required','string','max:255','unique:couleurs,couleur,except,id'],
            'color'=>['required','string','unique:couleurs,color,except,id']
        ]);

        Couleur::insert([
            ['couleur'=>request('couleur'),'color'=>request('color')]
        ]);
        
        return redirect()->route('articles.edit',$article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Couleur  $couleur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Couleur $couleur)
    {
        $articles = $couleur->articles();

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

        $couleur->delete();

        return redirect()->route('couleurs.index');
    }
}
