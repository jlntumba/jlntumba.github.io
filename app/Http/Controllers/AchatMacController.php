<?php

namespace App\Http\Controllers;

use App\Models\AchatMac;
use App\Http\Requests\StoreAchatMacRequest;
use App\Http\Requests\UpdateAchatMacRequest;
use App\Models\Article;
use App\Models\Couleur;
use App\Models\Mac;
use App\Models\Mode;
use App\Models\PanierMac;
use App\Models\Taille;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AchatMacController extends Controller
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
     * @param  \App\Http\Requests\StoreAchatMacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAchatMacRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AchatMac  $achatMac
     * @return \Illuminate\Http\Response
     */
    public function show(AchatMac $achatMac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AchatMac  $achatMac
     * @return \Illuminate\Http\Response
     */
    public function edit(AchatMac $achatMac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAchatMacRequest  $request
     * @param  \App\Models\AchatMac  $achatMac
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAchatMacRequest $request, AchatMac $achatMac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AchatMac  $achatMac
     * @return \Illuminate\Http\Response
     */
    public function destroy(AchatMac $achatMac)
    {
        //
    }
    
    public function validerPaiement(){

        $mac = Mac::where('mac',substr(exec('getmac'), 0, 17))->get()[0];

        $modeID = request('modeArtID');
        $tailleID = request('tailleArtID');
        $couleurID = request('couleurArtID');


        $articleID = request('artIDPaiement');
        $art = Article::find($articleID);
        $nbr = $art->nbr;

        $current = Carbon::now()->toDateTimeString();

            $addrs = request('addrs');
            $noms = request('noms');
            $tel = request('tel');
            $qte = PanierMac::where('article_id',$articleID)->where('mac',$mac->mac)->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->get('qte')[0]->qte;

            //dd($qte);
            $validator = request()->validate([
                'noms' => ['required', 'string', 'max:25'],
                'addrs' => ['required'],
                'tel' => ['required','numeric'],
            ]);
        
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
                PanierMac::where('article_id',$articleID)->where('mac',$mac->mac)->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->delete();
                $mode = Mode::find($modeID)->mode;
                $taille = ($tailleID==null || $tailleID=="") ? null : Taille::find($tailleID)->taille;
                $couleur = Couleur::find($couleurID)->couleur;
                $color = Couleur::find($couleurID)->color;
                AchatMac::insert([
                    ['noms'=>$noms,
                    'addrs'=>$addrs,
                    'tel'=>$tel,
                    'article_id'=>$art->id,
                    'marchand'=>$art->marchand,
                    'mac'=>$mac->mac,
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
