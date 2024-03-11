<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use App\Http\Requests\StoreMarqueRequest;
use App\Http\Requests\UpdateMarqueRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Panier;
use App\Models\PanierMac;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = request('type');
        $type = Type::find($id);
        $marques=Marque::all()->where('type_id',$type->id)->sortBy("marque");
        $cpt=1;
        return view('marques.index',compact('marques','cpt','type'));
    }
    public function list()
    {
        $id = request('type');
        $type = Type::find($id);
        $marques=Marque::where('type_id',$type->id)->get();
        return $marques;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = request('type');
        $type = Type::find($id);
        return view("marques.create",compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarqueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarqueRequest $request)
    {
        $this->validate($request,[
            'marque'=>['required','string','max:255']
        ]);

        Marque::insert([
            ['type_id'=>$request->type,'marque'=>$request->marque]
        ]);
         $type = Type::find($request->type);

        return redirect()->route('marques.index',compact('type'));
    }
    /**
     * Ajout d'une marque par popup modal : create article
     */
    public function addMarque(){
        $this->validate(request(),[
            'marque'=>['required','string','max:255','unique:marques,marque,except,id'],
        ]);

        Marque::insert([
            ['marque'=>request('marque'),'type_id'=>request('typeID')],
        ]);

        return redirect()->route('articles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function show(Marque $marque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function edit(Marque $marque)
    {
        $id = request('type');
        $type = Type::find($id);
        return view("marques.edit",compact('marque','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarqueRequest  $request
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarqueRequest $request, Marque $marque)
    {
        $this->validate($request,[
            'marque'=>['required','string','max:255']
        ]);

        $type = Type::find($request->type);

        $marques = Marque::all()->where('type_id',$type->id);
        foreach ($marques as $key) {
            if ($key->marque==$request->marque&&$marque->marque!=$request->marque) {
                $this->validate($request,[
                    'marque'=>['unique:marques,marque,except,id']
                ]);
                break;
            }
        }

        $marque->marque = $request->marque;
        $marque->save();

        return redirect()->route('marques.index',compact('type'));
    }
    /**
     * Ajout d'une marque par popup modal : update article
     */
    public function addMarqueU(Article $article){
        $this->validate(request(),[
            'marque'=>['required','string','max:255','unique:marques,marque,except,id']
        ]);

        Marque::create([
            'marque'=>request('marque'),
        ]);

        return redirect()->route('articles.edit',$article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marque  $marque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marque $marque)
    {
        $articles = $marque->articles();

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

        $type = Type::find(request('type'));

        $marque->delete();
        return redirect()->route('marques.index',compact('type'));
    }
}
