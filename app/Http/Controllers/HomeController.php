<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleTaille;
use App\Models\Mac;
use App\Models\Marque;
use App\Models\Mode;
use App\Models\Panier;
use App\Models\Province;
use App\Models\Taille;
use App\Models\Type;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $mac = Mac::where('mac',substr(exec('getmac'), 0, 17))->get();
        
        if ($mac->isEmpty()) {
            Mac::insert([['mac'=>substr(exec('getmac'), 0, 17)]]);
        }

      

        /*UserRole::insert([
            ['user_id'=>1,'role_id'=>1],
            ['user_id'=>1,'role_id'=>2],
            ['user_id'=>1,'role_id'=>3],
        ]);*/

        //dd(Auth::user());

        $articles = Article::all();
        $marques=Marque::all()->sortBy("marque");
        $typesVetement=Type::all()->sortBy("type");
        $modes=Mode::all();
        $tailles=Taille::all();

        $user = Auth::user();
        $provinces=Province::all()->sortBy("nom");
        $province = null;
        if ($user!=null&&$user->adresse_id!=null) {
            $user = User::find($user->id);
            $province = $user->adresse()[0]->province()[0];
        }
        $types = collect(["Boulevard","Direction","Avenue","Rue","Impasse","Autre"]);
        $codes = collect(["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"]);

        return view('home',compact('user','province','provinces','types','codes','modes','marques','tailles','typesVetement','articles'));
    }
}
