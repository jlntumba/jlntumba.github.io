<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\Adresse;
use App\Models\ArticleTaille;
use App\Models\Livraison;
use App\Models\Panier;
use App\Models\PanierMac;
use App\Models\Province;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nbrManagers = 0;
        $nbrMarchands = 0;
        $nbrUsers = 0;
        $users = User::all()->sortBy('name');

        foreach ($users as $user) {
            if ($user->roles()->contains(2)) {
                $nbrManagers++;
            }
            if($user->roles()->contains(3)){
                $nbrMarchands++;
            }
        }
        return view('users.index',compact('users','nbrManagers','nbrMarchands','nbrUsers'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        /**
         * Gestion, enregistrement, suppression photo de profil
         */
        if (request('profil')!=null) {
            $this->validate(request(),[
                'profil' => ['required']
            ]);
            
            $profil = request('profil');
    
            $path = 'app\public\images\profil\\'.$user->nom.$user->id;
    
            $disk = Storage::build([
                'driver'=>'local',
                'root'=>storage_path($path),
            ]);
    
            $disk->put('profil.png', $profil->getContent());
            $user->profil = $path;
            $user->save();
        }
        
        $adresse = $user->adresse()[0];
        return view('users.show',compact('user','adresse'));
    }

    /**
     * Suppression de la photo de profil
     */
    public function deleteProfil(User $user){
        $disk = Storage::build([
            'driver'=>'local',
            'root'=>storage_path($user->profil),
        ]);

        $files = $disk->files();
        foreach ($files as $photo ) {
            $disk->delete($photo);
        }
        
        $user->profil = null;
        $user->save();
        return $this->show($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $provinces=Province::all()->sortBy("nom");
        $province = null;
        if (!$user->adresse()->isEmpty()) {
            $province = $user->adresse()[0]->province()[0];
        }

        $types = collect(["Boulevard","Direction","Avenue","Rue","Impasse","Autre"]);
        $codes = collect(["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"]);

        $adresse = Adresse::find($user->adresse_id);
        $type = $adresse->type;
        $code = $adresse->code;

        return view("users.edit",compact("user","provinces","province","types","type","codes","code"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:25'],
            'postnom' => ['required','string','max:25'],
            'prenom' => ['required','string','max:25'],
            'sexe' => ['required','string','max:1'],
            'tel' => ['required','numeric'],
            'email' => ['required', 'string', 'email', 'max:255'],
            "type"=>['required','string'],
            "nom"=>['required','alpha','string'],
            "numero"=>['required','numeric'],
            "code"=>['string','max:1','nullable'],
            "quartier"=>['required','string','alpha'],
            "commune"=>['required','string','alpha'],
            "ref"=>['string'],
            "province"=>['required'],
        ]);

        if (($user->tel!=$request->tel)) {
            $this->validate($request,[
                'tel' => ['required','numeric','unique:users,tel,except,id']
            ]);
        }
        if (($user->email!=$request->email)) {
            $this->validate($request,[
                'email' => ['required', 'string', 'email', 'max:255','unique:users,email,except,id']
            ]);
        }

        $user->name = $request->name;
        $user->postnom = $request->postnom;
        $user->prenom = $request->prenom;
        $user->sexe = $request->sexe;
        $user->tel = $request->tel;
        $user->email = $request->email;

        $user->save();

        $adresse = $user->adresse()[0];
        $adresse->type = $request->type;
        $adresse->nom = $request->nom;
        $adresse->numero = $request->numero;
        $adresse->code = $request->code;
        $adresse->quartier = $request-> quartier;
        $adresse->commune = $request->commune;
        $adresse->ref = $request->ref;
        $adresse->province_id = $request->province;

        $adresse->save();

        return redirect()->route('users.show',compact('user','adresse'));
    }

    /**
     * Permettre ou enlever le droit de gerer
     */
    public function updateManagerValue(User $user){

        $user->roles()->contains(2) ? UserRole::where('user_id',$user->id)->where('role_id',2)->delete() : UserRole::insert([['user_id'=>$user->id,'role_id'=>2]]);

        return redirect()->route('users.index');
    }

    /**
     * Permettre ou enlever le droit de gerer
     * Si ce droit lui est enlevé, cela impact les articles postés et ajoutés dans les paniers d'autres
     * Sauf ceux déjà payés
     */
    public function updateMarchandValue(User $user){
        
        if ($user->roles()->contains(3)) {
            $articles = $user->marchandise();
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
            $user->nbrArtPost=0;
            $user->save();
        }

        $user->roles()->contains(3) ? UserRole::where('user_id',$user->id)->where('role_id',3)->delete() : UserRole::insert([['user_id'=>$user->id,'role_id'=>3]]);

        return redirect()->route('users.index');
    }

    /**
     * Recherche avec ajax des utilisateurs par leur code unique
     */
    public function searchUsers(){
        $search = request('search');
        $users = $search==null ? User::where('id','!=',1)->where('id','!=',Auth::user()->id)->get() : User::where('id','!=',1)->where('id','!=',Auth::user()->id)->where('code','like',$search)->get();
        $usersAll = collect();
        foreach ($users as $user) {
            $roles = $user->roles();
            $usersAll->push($user);
            $usersAll->push($roles);
        }
                        /*->orwhere('id','!=',1)->where('id','!=',Auth::user()->id)->where('tel','like','%'.$search.'%')
                        ->orwhere('id','!=',1)->where('id','!=',Auth::user()->id)->where('name','like','%'.$search.'%')
                        ->orwhere('id','!=',1)->where('id','!=',Auth::user()->id)->where('prenom','like','%'.$search.'%')
                        ->orwhere('id','!=',1)->where('id','!=',Auth::user()->id)->where('postnom','like','%'.$search.'%')->get();*/
        return $usersAll;
    }
    /**
     * Paramètre : code unique de l'utilisateur
     */
    public function searchUserRoles($code){
        $users = User::where('id','!=',1)->where('id','!=',Auth::user()->id)->where('code','like',$code)->get();
        return $users[0]->roles();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {        
        if ($user->roles()->contains(3)) {
            $articles = $user->marchandise();
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
        }
        UserRole::where('user_id',$user->id)->delete();

        $articlesLivres = $user->articlesLivres();
        foreach ($articlesLivres as $article) {
            $article->delete();
        }

        $user->nbrArtPost=0;
        $user->save();

        /**
         * Il ne peut supprimer son compte s'il a des articles payés à livrer à d'autres
         */
        $articlesVendus = $user->articlesVendus();
        if (!$articlesVendus->isEmpty()) {
            return Redirect::back()->withErrors(['msg'=>"Vous avez encore des articles à livrer avant de supprimer votre compte !"]);
        }

        $user->delete();
        return redirect()->route('home');
    }
}
