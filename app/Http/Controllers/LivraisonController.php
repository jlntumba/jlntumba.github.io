<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Http\Requests\StoreLivraisonRequest;
use App\Http\Requests\UpdateLivraisonRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\PanierMac;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLivraisonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLivraisonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function show(Livraison $livraison)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function edit(Livraison $livraison)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLivraisonRequest  $request
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLivraisonRequest $request, Livraison $livraison)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Livraison  $livraison
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livraison $livraison)
    {
        //
    }

    public function livrer($artID){
        $userID = request("user");
        $current = Carbon::now()->toDateTimeString();
        $achetes = Achat::where('article_id',$artID)->where('acheteur',$userID)->get();
        $marchand = null;
        $qteVendus = 0;
        foreach ($achetes as $achete) {
            Livraison::insert([
                ['article_id'=>$achete->article_id,
                'acheteur'=>$achete->acheteur,
                'marchand'=>$achete->marchand,
                'nom'=>$achete->nom,
                'description'=>$achete->description,
                'prix'=>$achete->prix,
                'devise'=>$achete->devise,
                'pathImg'=>$achete->pathImg,
                'marque'=>$achete->marque,
                'mode'=>$achete->mode,
                'type'=>$achete->type,
                'taille'=>$achete->taille,
                'couleur'=>$achete->couleur,
                'color'=>$achete->color,
                'qte'=>$achete->qte,
                'datePaiement'=>$achete->datePaiement,
                'dateLivraison'=>$current]
            ]);
            $qteVendus = $qteVendus + $achete->qte;
            $marchand = User::find($achete->marchand);
        }
        Achat::where('article_id',$artID)->where('acheteur',$userID)->delete();

        if ($marchand!=null) {
            /**
             * Nombre articles vendus ajouté
             */
            $nbrVendus = Auth::user()->nbrArtVend + $qteVendus;
            $user = User::find(Auth::user()->id);
            $user->nbrArtVend = $nbrVendus;
            $user->save();
        }

        $article = Article::find($artID);
        if ($article!=null) {
            /**
             * Nombre articles vendus ajouté
             */
            $nbrArtVendus = $article->nbrVendus + $qteVendus;
            $article->nbrVendus = $nbrArtVendus;
            $article->save();
        }

        return redirect()->back();
    }


    public function deleteLivraisonUser($e){
        $livre = Livraison::where('article_id',$e)->where('acheteur',Auth::user()->id)->first();

        Livraison::where('article_id',$e)->where('acheteur',Auth::user()->id)->delete();
        
        $achetes = Achat::all()->where('article_id',$e);
        $livres = Livraison::all()->where('article_id',$e);

        if ($achetes->isEmpty()&&$livres->isEmpty()) {
            $disk = Storage::build([
                'driver'=>'local',
                'root'=>storage_path('app\public\images\achat'),
            ]);

            $list = $disk->directories();
            foreach ($list as $item) {
                if($item==$livre->nom.$livre->article_id){
                    $disk->deleteDirectory($item);
                    break;
                }
            }
        }
        return redirect()->back();
    }
}
