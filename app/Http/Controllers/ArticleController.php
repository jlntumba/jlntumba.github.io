<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Achat;
use App\Models\AchatMac;
use App\Models\ArticleCouleur;
use App\Models\ArticleMode;
use App\Models\ArticleTaille;
use App\Models\Couleur;
use App\Models\Marque;
use App\Models\Mode;
use App\Models\Panier;
use App\Models\PanierMac;
use App\Models\Taille;
use App\Models\Type;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modes=Mode::all();
        $types=Type::all()->sortBy("type");
        $couleurs = Couleur::all()->sortBy('couleur');
        $marques=Marque::all()->sortBy("marque");
        $tailles=Taille::all();

        /**
         * Multiple suppression d'articles
         */
        $articles = Article::all();
        foreach ($articles as $article) {
            if (request($article->id)!=null) {
                $this->destroy($article);
            }
        }


        $articles = Article::all()->where('marchand',Auth::user()->id)->sortBy('nbr');
        $cpt=1;
        $count = $articles->count();
        return view('articles.index',compact('articles','cpt','count','modes','types','couleurs','marques','tailles'));
    }

    /**
     * Recherche d'un article avec filtre
     */
    public function searchArticlesEtFiltre(){

        $articles = collect();
        $articles = Article::all();
        $filtre = collect();

        $search = request('search');
        $marque = request('marque');
        $mode = request('mode');
        $type = request('type');
        $taille = request('taille');

        if ($search!=null) {
            $filtre = collect();
            $articlesSearch = Article::where('nom','like','%'.$search.'%')->orwhere('description','like','%'.$search.'%')->get();
            foreach ($articlesSearch as $article) {
                if (!$filtre->contains('id',$article->id)&&$articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre ; 
        } 
        if($marque!=null) {
            $filtre = collect();
            $articlesMarque = Article::where('marque_id','like',$marque)->get();
            foreach ($articlesMarque as $article) {
                if (!$filtre->contains('id',$article->id)&&$articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre ; 
        }
        if($mode!=null) {
            $filtre = collect();
            $item = Mode::find($mode);
            $articlesMode = $item->articles();
            foreach ($articlesMode as $article) {
                if (!$filtre->contains('id',$article->id)&&$articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre ;
        }
        if($type!=null) {
            $filtre = collect();
            $articlesType = Article::where('type_id','like',$type)->get();
            foreach ($articlesType as $article) {
                if (!$filtre->contains('id',$article->id)&&$articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre ; 
        }
        if($taille!=null) {
            $filtre = collect();
            $item = Taille::find($taille);
            $articlesTaille = $item->articles();
            foreach ($articlesTaille as $article) {
                if (!$filtre->contains('id',$article->id)&&$articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre ;
        }

        if ($search==null&&$marque==null&&$mode==null&&$type==null&&$taille==null) {
            $filtre = Article::all();
        }        
        
        return $filtre;
    }

    /**
     * Liste triée et filtrée par mode
     */
    public function listedByMode(){
        $modes = Mode::all();
        $modesArticlesAll = collect();
        $articlesAll = collect();
        foreach ($modes as $mode) {
            $articles = $mode->articles();

            foreach ($articles as $article) {
                if ($article->marchand==Auth::user()->id) {
                    $articlesAll->push($article);
                }
            }

            $modesArticlesAll->push($mode);
            $modesArticlesAll->push($articlesAll);
            $articlesAll = collect();
        }
        return $modesArticlesAll;
    }
    /**
     * Liste triée, affinée et filtrée par une mode
     */
    public function listedByOneMode(){
        $search = request('search');
        $modeId = request('modeId');

        $mode = Mode::find($modeId);
        $articles = $mode->articles();

        $modeArticlesAll = collect();
        $articlesAll = collect();

        $modeArticlesAll->push($mode);

        if ($search!=null) {
            $articles = Article::where('nom','like','%'.$search.'%')->where('mode_id','like',$modeId)->orwhere('description','like','%'.$search.'%')->where('mode_id','like',$modeId)->get();
        }

        foreach ($articles as $article) {
            if ($article->marchand==Auth::user()->id) {
                $articlesAll->push($article);
            }
        }

        $modeArticlesAll->push($articlesAll);

        return $modeArticlesAll;
        
    }

    /**
     * Liste triée et filtrée par type
     */
    public function listedByType(){
        $types = Type::all();
        $typesArticlesAll = collect();
        $articlesAll = collect();

        foreach ($types as $type) {
            $articles = $type->articles();

            foreach ($articles as $article) {
                if ($article->marchand==Auth::user()->id) {
                    $articlesAll->push($article);
                }
            }

            $typesArticlesAll->push($type);
            $typesArticlesAll->push($articlesAll);
            $articlesAll = collect();
        }
        return $typesArticlesAll;
    }
    /**
     * Liste triée, affinée et filtrée par un type
     */
    public function listedByOneType(){
        $typeId = request('typeId');
        
        $type = Type::find($typeId);
        $marques = $type->marques();
        $articles = $type->articles();

        $typeArticlesAll = collect();
        $articlesAll = collect();

        $typeArticlesAll->push($type);

        foreach ($articles as $article) {
            if ($article->marchand==Auth::user()->id) {
                $articlesAll->push($article);
            }
        }

        $typeArticlesAll->push($articlesAll);
        $typeArticlesAll->push($marques);

        return $typeArticlesAll;
    }

    /**
     * Liste triée et filtrée par couleurs
     */
    public function listedByCouleur(){
        $couleurs = Couleur::all()->sortBy('couleur');
        $couleursArticlesAll = collect();
        $articlesAll = collect();
        foreach ($couleurs as $couleur) {
            $articles = $couleur->articles();

            foreach ($articles as $article) {
                if ($article->marchand==Auth::user()->id) {
                    $articlesAll->push($article);
                }
            }

            $couleursArticlesAll->push($couleur);
            $couleursArticlesAll->push($articlesAll);
            $articlesAll = collect();
        }
        return $couleursArticlesAll;
    }
    /**
     * Liste triée, affinée et filtrée par un couleur
     */
    public function listedByOneCouleur(){
        $search = request('search');
        $couleurId = request('couleurId');
        
        $couleur = Couleur::find($couleurId);
        $articles = $couleur->articles();

        $couleurArticlesAll = collect();
        $articlesAll = collect();
        $filtre = collect();

        $couleurArticlesAll->push($couleur);

        if ($search!=null) {
            $articlesSearch = Article::where('nom','like','%'.$search.'%')->orwhere('description','like','%'.$search.'%')->get();
            foreach ($articlesSearch as $article) {
                if ($articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre;
        }

        foreach ($articles as $article) {
            if ($article->marchand==Auth::user()->id) {
                $articlesAll->push($article);
            }
        }

        $couleurArticlesAll->push($articlesAll);

        return $couleurArticlesAll;
    }

    /**
     * Liste triée et filtrée par marque
     */
    public function listedByMarque(){
        $marques = Marque::all()->sortBy('marque');
        $marquesArticlesAll = collect();
        $articlesAll = collect();

        foreach ($marques as $marque) {
            $articles = $marque->articles();

            foreach ($articles as $article) {
                if ($article->marchand==Auth::user()->id) {
                    $articlesAll->push($article);
                }
            }

            $marquesArticlesAll->push($marque);
            $marquesArticlesAll->push($articlesAll);
            $articlesAll = collect();
        }
        return $marquesArticlesAll;
    }
    /**
     * Liste triée, affinée et filtrée par une marque
     */
    public function listedByOneMarque(){
        $search = request('search');
        $marqueId = request('marqueId');
        
        $marque = Marque::find($marqueId);
        $articles = $marque->articles();

        $marqueArticlesAll = collect();
        $articlesAll = collect();

        $marqueArticlesAll->push($marque);

        if ($search!=null) {
            $articles = Article::where('nom','like','%'.$search.'%')->where('marque_id','like',$marqueId)->orwhere('description','like','%'.$search.'%')->where('marque_id','like',$marqueId)->get();
        }

        foreach ($articles as $article) {
            if ($article->marchand==Auth::user()->id) {
                $articlesAll->push($article);
            }
        }

        $marqueArticlesAll->push($articlesAll);

        return $marqueArticlesAll;
    }

    /**
     * Liste triée et filtrée par taille
     */
    public function listedByTaille(){
        $tailles = Taille::all();
        $taillesArticlesAll = collect();
        $articlesAll = collect();
        foreach ($tailles as $taille) {
            $articles = $taille->articles();

            foreach ($articles as $article) {
                if ($article->marchand==Auth::user()->id) {
                    $articlesAll->push($article);
                }
            }

            $taillesArticlesAll->push($taille);
            $taillesArticlesAll->push($articlesAll);
            $articlesAll = collect();
        }
        return $taillesArticlesAll;
    }
    /**
     * Liste triée, affinée et filtrée par une taille
     */
    public function listedByOneTaille(){
        $search = request('search');
        $tailleId = request('tailleId');
        
        $taille = Taille::find($tailleId);
        $articles = $taille->articles();

        $tailleArticlesAll = collect();
        $articlesAll = collect();
        $filtre = collect();

        $tailleArticlesAll->push($taille);

        if ($search!=null) {
            $articlesSearch = Article::where('nom','like','%'.$search.'%')->orwhere('description','like','%'.$search.'%')->get();
            foreach ($articlesSearch as $article) {
                if ($articles->contains('id',$article->id)) {
                    $filtre->push($article);
                }
            }
            $articles = $filtre;
        }

        foreach ($articles as $article) {
            if ($article->marchand==Auth::user()->id) {
                $articlesAll->push($article);
            }
        }

        $tailleArticlesAll->push($articlesAll);

        return $tailleArticlesAll;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modes = Mode::all();
        $types = Type::all();
        $tailles = Taille::all();
        $couleurs = Couleur::all()->sortBy('couleur');
        return view('articles.create', compact('modes','types','tailles','couleurs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        /**
         * Validation mode afin qu'au moins une soit chosie
         */
        $modes = Mode::all();
        $i = 0;
        foreach ($modes as $mode ) {
            $id = "mode".$mode->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$modes->count()) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une mode svp !"]);
        }
        
        /**
         * Validation taille afin qu'au moins une soit chosie
         */
        $tailles = Taille::all();
        $i = 0;
        foreach ($tailles as $taille ) {
            $id = "taille".$taille->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$tailles->count()&&$request->type==1) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une taille svp !"]);
        }

        /**
         * Validation couleur afin qu'au moins une soit chosie
         */
        $couleurs = Couleur::all();
        $i = 0;
        foreach ($couleurs as $couleur ) {
            $id = "couleur".$couleur->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$couleurs->count()) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une couleur svp !"]);
        }

        $this->validate($request,[
            'profil' => ['required'],
            'nom' => ['required','max:255'],
            'nbr' => ['required','numeric','gte:0'],
            'devise' => ['required'],
            'marque' => ['required'],
            'type' => ['required'],
            'prix' => ['required','numeric','gt:0'],
            'description' => ['required'],
        ]);
        
        $profil = $request->file('profil');
        $nom = $request->nom;
        $nbr = $request->nbr;
        $devise = $request->devise;
        $marque = $request->marque;
        $type = $request->type;
        $prix = $request->prix;
        $description = $request->description;

        Article::insert([
            'marchand'=>Auth::user()->id,'nom'=>$nom,'description'=>$description,'prix'=>$prix,'devise'=>$devise,'nbr'=>$nbr,'marque_id'=>$marque,'type_id'=>$type
        ]);
        $article = Article::where('nom',$nom)
                          ->where('description',$description)
                          ->where('prix',$prix)
                          ->where('devise',$devise)
                          ->where('nbr',$nbr)
                          ->where('marque_id',$marque)
                          ->where('type_id',$type)->get()[0];
        
        foreach ($modes as $mode ) {
            $id = "mode".$mode->id;
            if ($request->$id!=null) {
                ArticleMode::insert([
                    'article_id'=>$article->id,'mode_id'=>$mode->id
                ]);                
            }
        }
        foreach ($tailles as $taille ) {
            $id = "taille".$taille->id;
            if ($request->$id!=null) {
                ArticleTaille::insert([
                    'article_id'=>$article->id,'taille_id'=>$taille->id
                ]);                
            }
        }
        $couleurs=Couleur::all();
        foreach ($couleurs as $couleur ) {
            $id = "couleur".$couleur->id;
            if ($request->$id==1) {
                ArticleCouleur::insert([
                    'article_id'=>$article->id,'couleur_id'=>$couleur->id
                ]);                
            }
        }

        $path = 'app\public\images\\'.$nom.$article->id;

        $disk = Storage::build([
            'driver'=>'local',
            'root'=>storage_path($path),
        ]);

        
        $disk->put('profil.png', $profil->getContent());
           

        $article->pathImg = $path;
        $article->save();

        /**
         * Si l'utilisateur auth est marchand ou pas
         */
        $estMarchand = false;
        if (Auth::user()!=null) {
            $estMarchand = ($article->marchand()->id==Auth::user()->id);
        }

        $type = $article->type();
        $articlesType = $type->articles();

        $marchand = $article->marchand();
        $marchand = User::find($marchand->id);
        $articlesMarchand = $marchand->marchandise();

        /**
         * Nombre articles postés ajouté
         */
        $nbrPostes = Auth::user()->nbrArtPost + 1;
        $user = User::find(Auth::user()->id);
        $user->nbrArtPost = $nbrPostes;
        $user->save();

        
        return view('articles.show',compact('article','estMarchand','articlesType','articlesMarchand'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $path = $article->pathImg;
        $disk = Storage::build([
            'driver'=>'local',
            'root'=>storage_path($path),
        ]);

        /**
         * Suppression d'un ou de plusieurs images
         */
        foreach (Storage::build(['driver'=>'local','root'=>storage_path($article->pathImg),])->files() as $item) {            
            $replaced = str_replace('.', '_', $item);
            if (request($replaced)!=null) {
                $disk->delete($item);
            }
        }

        /**
         * Si l'utilisateur auth est marchand ou pas
         */
        $estMarchand = false;
        if (Auth::user()!=null) {
            $estMarchand = ($article->marchand()->id==Auth::user()->id);
        }

        $type = $article->type();
        $articlesType = $type->articles();

        $marchand = $article->marchand();
        $marchand = User::find($marchand->id);
        $articlesMarchand = $marchand->marchandise();
        
        return view('articles.show',compact('article','estMarchand','articlesType','articlesMarchand'));
    }

    /**
     * Ajout d'un ou plusieures images pour un article
     */
    public function addImages(Article $article)
    {
        $this->validate(request(),[
            'photos' => ['required']
        ]);

        $photos = request('photos');

        $path = $article->pathImg;
        $disk = Storage::build([
            'driver'=>'local',
            'root'=>storage_path($path),
        ]);

        $cpt=1;
        foreach ($photos as $photo) {
            $nom = ''.$cpt.'.'.$photo->getClientOriginalExtension();

            /**
             * Une image avec un nom différent de celles qui exsitent
             */
            while (in_array($nom,$disk->files())) {
                $cpt++;
                $nom = ''.$cpt.'.'.$photo->getClientOriginalExtension();
            }

            /**
             * Contrôle afin que l'image ajoutée ne soit pas déjà là
             */
            foreach ($disk->files() as $file ) {
                if ($photo->getContent()==$disk->get($file)) {
                    return Redirect::back()->withErrors(['msg'=>"L'une des images existe déjà !"]);
                }
            }

            $disk->put($nom, $photo->getContent());
            $cpt++;
        }

        /**
         * Si l'utilisateur auth est marchand ou pas
         */
        $estMarchand = false;
        if (Auth::user()!=null) {
            $estMarchand = ($article->marchand()->id==Auth::user()->id);
        }

        $type = $article->type();
        $articlesType = $type->articles();

        $marchand = $article->marchand();
        $marchand = User::find($marchand->id);
        $articlesMarchand = $marchand->marchandise();
        
        return view('articles.show',compact('article','estMarchand','articlesType','articlesMarchand'));
    }

    /**
     * Ajouter l'article dans le panier
     */
    public function remplirPanier()
    {
        $articleID = request('article');
        $article = Article::find($articleID);


        $validator = request()->validate([
            'qte' => ['required','numeric','gt:0'],
            'moderadio' => ['required'],
            'couleurradio' => ['required'],
        ]);

        if ($article->type()->id==1) {
            $validator = request()->validate([
                'tailleradio' => ['required'],
            ]);
        }

        $user = Auth::user();
        $mac = substr(exec('getmac'), 0, 17);
        $qte = request('qte');
        $moderadio = request('moderadio');
        $tailleradio = request('tailleradio');
        $couleurradio = request('couleurradio');

        /**
         * Compte sans puis avec user authentifié
         */
        if ($user==null) {
            $panier = PanierMac::where('mac',$mac)->where('article_id',$articleID)->where('mode_id',$moderadio)->where('taille_id',$tailleradio)->where('couleur_id',$couleurradio)->get();
            /**
             * S'il n'y a rien de cet article, on insert dans le panier
             */
            if ($panier->isEmpty()) {
                PanierMac::insert([
                    ['mac'=>$mac,'article_id'=>$articleID,'qte'=>$qte,'mode_id'=>$moderadio,'taille_id'=>$tailleradio,'couleur_id'=>$couleurradio],
                ]);
            } else {
                PanierMac::where('mac',$mac)->where('article_id',$articleID)->where('mode_id',$moderadio)->where('taille_id',$tailleradio)->where('couleur_id',$couleurradio)->update(['qte'=>$qte]);                
            }
            return redirect()->route('panierMac');
        } else {
            $panierU = Panier::where('user_id',$user->id)->where('article_id',$articleID)->where('mode_id',$moderadio)->where('taille_id',$tailleradio)->where('couleur_id',$couleurradio)->get();
            /**
             * S'il n'y a rien de cet article, on insert dans le panier
             * sinon, on MàJ
             */
            if ($panierU->isEmpty()) {
                Panier::insert([
                    ['user_id'=>$user->id,'article_id'=>$articleID,'qte'=>$qte,'mode_id'=>$moderadio,'taille_id'=>$tailleradio,'couleur_id'=>$couleurradio],
                ]);
            } else {
                Panier::where('user_id',$user->id)->where('article_id',$articleID)
                ->update(['qte'=>$qte]);
            }
            return redirect()->route('panierUser');
        }
    }

    /**
     * Articles à livrer/livrés
     */
    public function ouvrirLivraison(){
        $aLivrer = Achat::all()->where('marchand',Auth::user()->id)->sortBy('datePaiement');
        $userIds = collect();
        foreach ($aLivrer as $achat) {
            $userIds->push($achat->acheteur);
        }
        $users = User::all()->whereIn('id',$userIds);
        $ids = collect();
        
        $aLivrerMac = AchatMac::all()->where('marchand',Auth::user()->id)->sortBy('datePaiement');
        $tels = collect();
        foreach ($aLivrerMac as $achat) {
            if (!$tels->contains($achat->tel)) {
                $tels->push($achat->tel);
            }
        }
        $idsMac = collect();

        return view('articles.livraison',compact('tels','users','ids','idsMac'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $marqueArt = $article->marque()[0];
        $modesArt = $article->modes();
        $typeArt = $article->type();
        $taillesArt = $article->tailles();
        $couleursArt = $article->couleurs();
        
        $modes = Mode::all();
        $types = Type::all()->where('id','!=',$typeArt->id);
        $tailles = Taille::all();
        $couleurs = Couleur::all()->sortBy('couleur');
        $marques = Marque::all()->where('type_id',$typeArt->id)->where('id','!=',$marqueArt->id);

        return view('articles.edit',compact('article','marques','marqueArt','modes','modesArt','types','typeArt','tailles','taillesArt','couleurs','couleursArt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        /**
         * Validation mode afin qu'au moins une soit chosie
         */
        $modes = Mode::all();
        $i = 0;
        foreach ($modes as $mode ) {
            $id = "mode".$mode->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$modes->count()) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une mode svp !"]);
        }
        
        /**
         * Validation taille afin qu'au moins une soit chosie
         */
        $tailles = Taille::all();
        $i = 0;
        foreach ($tailles as $taille ) {
            $id = "taille".$taille->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$tailles->count()&&$request->type==1) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une taille svp !"]);
        }

        /**
         * Validation couleur afin qu'au moins une soit chosie
         */
        $couleurs = Couleur::all();
        $i = 0;
        foreach ($couleurs as $couleur ) {
            $id = "couleur".$couleur->id;
            if ($request->$id==null) {
                $i++;
            }
        }
        if ($i==$couleurs->count()) {
            return Redirect::back()->withErrors(['msg'=>"Choisissez au moins une couleur svp !"]);
        }

        $this->validate($request,[
            'nom' => ['required','max:255'],
            'nbr' => ['required','numeric','gte:0'],
            'devise' => ['required'],
            'marque' => ['required'],
            'type' => ['required'],
            'prix' => ['required','numeric','gt:0'],
            'description' => ['required'],
        ]);

        $article->nom = $request->nom;
        $article->nbr = $request->nbr;
        $article->devise = $request->devise;
        $article->marque_id = $request->marque;
        $article->type_id = $request->type;
        $article->prix = $request->prix;
        $article->description = $request->description;

        $tailles = Taille::all();
        $taillesArt = $article->tailles();

        foreach ($taillesArt as $tailleArt) {
            $id="taille".$tailleArt->id;
            if ($request->$id==null) {
                ArticleTaille::where("article_id",$article->id)->where("taille_id",$tailleArt->id)->delete();
            }
        }

        foreach ($tailles as $taille ) {
            $id = "taille".$taille->id;
            if ($request->$id!=null&&!$taillesArt->contains($taille)) {
                ArticleTaille::insert([
                    'article_id'=>$article->id,'taille_id'=>$taille->id
                ]);
            }
        }

        $modes = Mode::all();
        $modesArt = $article->modes();

        foreach ($modesArt as $modeArt) {
            $id="mode".$modeArt->id;
            if ($request->$id==null) {
                ArticleMode::where("article_id",$article->id)->where("mode_id",$modeArt->id)->delete();
            }
        }

        foreach ($modes as $mode ) {
            $id = "mode".$mode->id;
            if ($request->$id!=null&&!$modesArt->contains($mode)) {
                ArticleMode::insert([
                    'article_id'=>$article->id,'mode_id'=>$mode->id
                ]);
            }
        }

        $couleurs = Couleur::all();
        $couleursArt = $article->couleurs();

        foreach ($couleursArt as $couleurArt) {
            $id="couleur".$couleurArt->id;
            if ($request->$id==null) {
                ArticleCouleur::where("article_id",$article->id)->where("couleur_id",$couleurArt->id)->delete();
            }
        }

        foreach ($couleurs as $couleur ) {
            $id = "couleur".$couleur->id;
            if ($request->$id!=null&&!$couleursArt->contains($couleur)) {
                ArticleCouleur::insert([
                    'article_id'=>$article->id,'couleur_id'=>$couleur->id
                ]);
            }
        }


        if ($request->type!=1) {
            ArticleTaille::where('article_id',$article->id)->delete();
        }

        $article->save();

        return $this->show($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {

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

        /**
         * Nombre articles postés diminué
         */
        $nbrPostes = Auth::user()->nbrArtPost - 1;
        $user = User::find(Auth::user()->id);
        $user->nbrArtPost = $nbrPostes;
        $user->save();

        return redirect()->route('articles.index');
    }
}
