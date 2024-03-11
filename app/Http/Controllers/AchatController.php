<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Http\Requests\StoreAchatRequest;
use App\Http\Requests\UpdateAchatRequest;
use App\Models\Article;
use App\Models\Couleur;
use App\Models\Mode;
use App\Models\Panier;
use App\Models\PanierMac;
use App\Models\Taille;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AchatController extends Controller
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
     * @param  \App\Http\Requests\StoreAchatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAchatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function show(Achat $achat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function edit(Achat $achat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAchatRequest  $request
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAchatRequest $request, Achat $achat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Achat  $achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Achat $achat)
    {
        //
    }

    
    public function validerPaiement(){

        $user = Auth::user();

        $modeID = request('modeArtID');
        $tailleID = request('tailleArtID');
        $couleurID = request('couleurArtID');

        $articleID = request('artIDPaiement');
        $art = Article::find($articleID);
        $nbr = $art->nbr;

        $current = Carbon::now()->toDateTimeString();

            $qte = Panier::where('article_id',$articleID)->where('user_id',$user->id)->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->get('qte')[0]->qte;

            /**
             * Le nombre des articles diminue ensuite l'article est marqué payé
             */
            if ($nbr>=$qte) {

                /**
                 * Getting the content of the art's profil
                 */
                $pathArt = $art->pathImg;

                $disk1 = Storage::build([
                    'driver'=>'local',
                    'root'=>storage_path($pathArt),
                ]);

                $profil = $disk1->get('profil.png');

                /**
                 * Putting the profil for the sold one
                 */
                $pathArtAchat = 'app\public\images\achat\\'.$art->nom.$art->id;

                $disk2 = Storage::build([
                    'driver'=>'local',
                    'root'=>storage_path($pathArtAchat),
                ]);

                $disk2->put('profil.png', $profil);

                ////

                Article::where('id',$art->id)->update(['nbr'=>($nbr-$qte)]);
                Panier::where('article_id',$articleID)->where('user_id',$user->id)->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->delete();
                $mode = Mode::find($modeID)->mode;
                $taille = ($tailleID==null || $tailleID=="") ? null : Taille::find($tailleID)->taille;
                $couleur = Couleur::find($couleurID)->couleur;
                $color = Couleur::find($couleurID)->color;
                Achat::insert([
                    ['article_id'=>$art->id,
                    'acheteur'=>$user->id,
                    'marchand'=>$art->marchand,
                    'nom'=>$art->nom,
                    'description'=>$art->description,
                    'prix'=>$art->prix,
                    'devise'=>$art->devise,
                    'pathImg'=>$pathArtAchat,
                    'marque'=>$art->marque()[0]->marque,
                    'mode'=>$mode,
                    'type'=>$art->type()->type,
                    'taille'=>$taille,
                    'couleur'=>$couleur,
                    'color'=>$color,
                    'qte'=>$qte,
                    'datePaiement'=>$current],
                ]);
            }
        return redirect()->back();
    }
}
