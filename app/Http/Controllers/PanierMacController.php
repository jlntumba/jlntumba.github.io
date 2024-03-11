<?php

namespace App\Http\Controllers;

use App\Models\PanierMac;
use App\Http\Requests\StorePanierMacRequest;
use App\Http\Requests\UpdatePanierMacRequest;
use App\Models\AchatMac;
use App\Models\Mac;

class PanierMacController extends Controller
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
     * @param  \App\Http\Requests\StorePanierMacRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePanierMacRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PanierMac  $panierMac
     * @return \Illuminate\Http\Response
     */
    public function show(PanierMac $panierMac)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PanierMac  $panierMac
     * @return \Illuminate\Http\Response
     */
    public function edit(PanierMac $panierMac)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePanierMacRequest  $request
     * @param  \App\Models\PanierMac  $panierMac
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePanierMacRequest $request, PanierMac $panierMac)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PanierMac  $panierMac
     * @return \Illuminate\Http\Response
     */
    public function destroy(PanierMac $panierMac)
    {
        //
    }

    /**
     * Sans user mais avec l'adresse Mac de l'ordinateur
     */
    public function ouvrirPanier(){
        $mac = Mac::where('mac',substr(exec('getmac'), 0, 17))->get()[0];
        $panier = PanierMac::where('mac',$mac->mac)->get()->sortBy('article_id');
        
        $articlesAjoutes = $mac->articlesAjoutes();
        $articlesAjoutes = $articlesAjoutes->sortBy('id');

        $articlesAchetes = $mac->articlesAchetes();
        $articlesAchetes = $articlesAchetes->sortBy('id');
        //dd($articlesAchetes);
        $articlesRecus = $mac->articlesRecus();
        $articlesRecus = $articlesRecus->sortBy('id');
        //dd($articlesRecus);
        $id=0;
        $idR = 0;
        $tel = "";
        return view('panier',compact('panier','articlesAjoutes','articlesAchetes','articlesRecus','id','idR','mac'));
    }

    public function deletePanier($e){
        $modeID = request('modeID');
        $tailleID = request('tailleID');
        $couleurID = request('couleurID');
        PanierMac::where('article_id',$e)->where('mac',substr(exec('getmac'), 0, 17))->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->delete();
        return redirect()->back();
    }

    public function ajouterQte(){
        $mac = substr(exec('getmac'), 0, 17);
        $qte = request('qte');
        $artID = request('artID');
        $artMode = request('artMode');
        $artTaille = request('artTaille');
        $artCouleur = request('artCouleur');
        
            PanierMac::where('article_id',$artID)->where('mac',$mac)->where('mode_id',$artMode)->where('taille_id',$artTaille)->where('couleur_id',$artCouleur)->update(['qte'=>$qte]);
            
        return $qte;
    }
}
