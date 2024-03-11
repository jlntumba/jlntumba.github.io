<?php

namespace App\Http\Controllers;

use App\Models\Adresse;
use App\Http\Requests\StoreAdresseRequest;
use App\Http\Requests\UpdateAdresseRequest;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;

class AdresseController extends Controller
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
     * @param  \App\Http\Requests\StoreAdresseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdresseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function show(Adresse $adresse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function edit(Adresse $adresse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdresseRequest  $request
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdresseRequest $request, Adresse $adresse)
    {
        $this->validate($request,[
            "type"=>['required','string'],
            "nom"=>['required','string'],
            "numero"=>['required','numeric'],
            "code"=>['string','max:1','nullable'],
            "quartier"=>['required','string'],
            "commune"=>['required','string'],
            "ref"=>['string'],
            "province"=>['required']
        ]);

        $adresse->type = $request->type;
        $adresse->nom = $request->nom;
        $adresse->numero = $request->numero;
        $adresse->code = $request->code;
        $adresse->quartier = $request-> quartier;
        $adresse->commune = $request->commune;
        $adresse->ref = $request->ref;
        $adresse->province_id = $request->province;
        $adresse->save();

        $adresse = Adresse::where('type',$request->type)
                            ->where('nom',$request->nom)
                            ->where('numero',$request->numero)
                            ->where('code',$request->code)
                            ->where('quartier',$request->quartier)
                            ->where('commune',$request->commune)
                            ->where('province_id',$request->province)->get()[0];

        $user = Auth::user();
        $user->adresse_id = $adresse->id;
        $user->save();

        return redirect()->route('users.show',compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Adresse $adresse)
    {
        //
    }
}
