<?php

namespace App\Http\Controllers;

use App\Models\LivraisonMac;
use App\Http\Requests\StoreLivraisonMacRequest;
use App\Http\Requests\UpdateLivraisonMacRequest;
use App\Models\AchatMac;
use App\Models\Article;
use App\Models\Mac;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LivraisonMacController extends Controller
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
     * @param  \App\Http\Requests\StoreLivraisonMacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLivraisonMacRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LivraisonMac  $livraisonMac
     * @return \Illuminate\Http\Response
     */
    public function show(LivraisonMac $livraisonMac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LivraisonMac  $livraisonMac
     * @return \Illuminate\Http\Response
     */
    public function edit(LivraisonMac $livraisonMac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLivraisonMacRequest  $request
     * @param  \App\Models\LivraisonMac  $livraisonMac
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLivraisonMacRequest $request, LivraisonMac $livraisonMac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LivraisonMac  $livraisonMac
     * @return \Illuminate\Http\Response
     */
    public function destroy(LivraisonMac $livraisonMac)
    {
        //
    }

    public function livrer($artID){
        $tel = request("tel");
        $mac = Mac::where('mac',substr(exec('getmac'), 0, 17))->get()[0];
        $current = Carbon::now()->toDateTimeString();
        $achetes = AchatMac::where('article_id',$artID)->where('tel',$tel)->get();
        $marchand = null;
        $qteVendus = 0;
        foreach ($achetes as $achete) {
            LivraisonMac::insert([
                ['noms'=>$achete->noms,
                'addrs'=>$achete->addrs,
                'tel'=>$achete->tel,
                'article_id'=>$achete->article_id,
                'marchand'=>$achete->marchand,
                'mac'=>$mac->mac,
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
        AchatMac::where('article_id',$artID)->where('tel',$tel)->delete();//$achete->delete();
        
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

    public function deleteLivraison($e){
        $mac = Mac::where('mac',substr(exec('getmac'), 0, 17))->get()[0];

        $livre = LivraisonMac::where('article_id',$e)->where('mac',$mac->mac)->first();

        LivraisonMac::where('article_id',$e)->where('mac',$mac->mac)->delete();
        
        $achetes = AchatMac::all()->where('article_id',$e);
        $livres = LivraisonMac::all()->where('article_id',$e);

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
