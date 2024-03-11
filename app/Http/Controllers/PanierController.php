<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Http\Requests\StorePanierRequest;
use App\Http\Requests\UpdatePanierRequest;
use App\Models\Achat;
use App\Models\Article;
use App\Models\Livraison;
use App\Models\PanierMac;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PanierController extends Controller
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
     * @param  \App\Http\Requests\StorePanierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePanierRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function show(Panier $panier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function edit(Panier $panier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePanierRequest  $request
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePanierRequest $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panier  $panier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panier $panier)
    {
        //
    }

    public function ouvrirPanierUser(){
        $user = User::find(Auth::user()->id);
        $panier = Panier::where('user_id',$user->id)->get()->sortBy('article_id');

        $articlesAjoutes = $user->articlesAjoutes();
        $articlesAjoutes = $articlesAjoutes->sortBy('id');

        $articlesAchetes = $user->articlesAchetes();
        $articlesAchetes = $articlesAchetes->sortBy('id');
        
        $articlesRecus = $user->articlesRecus();
        $articlesRecus = $articlesRecus->sortBy('id');
        $id=0;
        $idR = 0;
        return view('users.panier',compact('panier','articlesAjoutes','articlesAchetes','articlesRecus','id','idR'));
    }

    public function deletePanierUser($e){
        $modeID = request('modeID');
        $tailleID = request('tailleID');
        $couleurID = request('couleurID');
        Panier::where('article_id',$e)->where('user_id',Auth::user()->id)->where('mode_id',$modeID)->where('taille_id',$tailleID)->where('couleur_id',$couleurID)->delete();
        return redirect()->back();
    }

    public function ajouterQte(){
        $user = Auth::user();
        $qte = request('qte');
        $artID = request('artID');
        $artMode = request('artMode');
        $artTaille = request('artTaille');
        $artCouleur = request('artCouleur');
        
            Panier::where('article_id',$artID)->where('user_id',$user->id)->where('mode_id',$artMode)->where('taille_id',$artTaille)->where('couleur_id',$artCouleur)->update(['qte'=>$qte]);
        
        return $qte;
    }

}
