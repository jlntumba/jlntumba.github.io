<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Panier;
use App\Models\PanierMac;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types=Type::all();
        $cpt=1;
        return view('types.index',compact('types','cpt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("types.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        $this->validate($request,[
            'type'=>['required','string','max:255','unique:types,type,except,id']
        ]);

        Type::create([
            'type'=>$request->type,
        ]);

        return redirect()->route('types.index');
    }
    /**
     * Ajout d'un type par popup modal : create article
     */
    public function addType(){
        $this->validate(request(),[
            'type'=>['required','string','max:255','unique:types,type,except,id']
        ]);

        Type::create([
            'type'=>request('type'),
        ]);

        return redirect()->route('articles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view("types.edit",compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $this->validate($request,[
            'type'=>['required','string','max:255']
        ]);

        if (($type->type!=$request->type)) {
            $this->validate($request,[
                'type'=>['required','string','max:255','unique:types,type,except,id']
            ]);
        }
        
        $type->update([
            'type'=>$request->type,
        ]);

        return redirect()->route('types.index');
    }
    /**
     * Ajout d'un type par popup modal : create article
     */
    public function addTypeU(Article $article){
        $this->validate(request(),[
            'type'=>['required','string','max:255','unique:types,type,except,id']
        ]);

        Type::create([
            'type'=>request('type'),
        ]);

        return redirect()->route('articles.edit',$article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $articles = $type->articles();

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

        $type->delete();

        return redirect()->route('types.index');
    }
}