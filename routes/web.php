<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\Province;
use App\Models\Adresse;
use App\Models\User;
use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[App\Http\Controllers\HomeController::class, 'index']);

Route::resource('users',App\Http\Controllers\UserController::class);
Route::resource('adresses',App\Http\Controllers\AdresseController::class);
Route::resource('marques',App\Http\Controllers\MarqueController::class); Route::get('type/marques', [App\Http\Controllers\MarqueController::class, 'list'])->name('listMarques');
Route::resource('tailles',App\Http\Controllers\TailleController::class);
Route::resource('modes',App\Http\Controllers\ModeController::class);
Route::resource('types',App\Http\Controllers\TypeController::class);
Route::resource('couleurs',App\Http\Controllers\CouleurController::class);
Route::resource('articles',App\Http\Controllers\ArticleController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('mail',[App\Http\Controllers\OrderController::class,'store'])->name('mail');

Route::get('article',[App\Http\Controllers\ArticleController::class,'show'])->name('article');

Route::post('articles/{article}/images',[App\Http\Controllers\ArticleController::class,'addImages'])->name('images');

/**
 * While creating an article
 */
Route::post('marques/marque',[App\Http\Controllers\MarqueController::class,'addMarque'])->name('marque');
Route::post('modes/mode',[App\Http\Controllers\ModeController::class,'addMode'])->name('mode');
Route::post('types/type',[App\Http\Controllers\TypeController::class,'addType'])->name('type');
Route::post('taille/taille',[App\Http\Controllers\TailleController::class,'addTaille'])->name('taille');
Route::post('couleur/couleur',[App\Http\Controllers\CouleurController::class,'addCouleur'])->name('couleur');

/**
 * While updating an article
 */
Route::post('marques/marque/{article}',[App\Http\Controllers\MarqueController::class,'addMarqueU'])->name('marqueU');
Route::post('modes/mode/{article}',[App\Http\Controllers\ModeController::class,'addModeU'])->name('modeU');
Route::post('types/type/{article}',[App\Http\Controllers\TypeController::class,'addTypeU'])->name('typeU');
Route::post('taille/taille/{article}',[App\Http\Controllers\TailleController::class,'addTailleU'])->name('tailleU');
Route::post('couleur/couleur/{article}',[App\Http\Controllers\CouleurController::class,'addCouleurU'])->name('couleurU');

/**
 * Deleting profil's image
 */
Route::get('users/{user}/profil',[App\Http\Controllers\UserController::class,'deleteProfil'])->name('deleteProfil');

/**
 * Admin or manager or livreur
 */
Route::get('users/manager/{user}',[App\Http\Controllers\UserController::class,'updateManagerValue'])->name('manager');
Route::get('users/marchand/{user}',[App\Http\Controllers\UserController::class,'updateMarchandValue'])->name('marchand');

/**
 * User search : ajax
 */
Route::post('users/search/users',[App\Http\Controllers\UserController::class,'searchUsers'])->name('search');
Route::get('users/search/users/{code}',[App\Http\Controllers\UserController::class,'searchUserRoles']);

/**
 * Articles search : ajax
 */
Route::post('articles/search/articles',[App\Http\Controllers\ArticleController::class,'searchArticlesEtFiltre'])->name('searchArticles');

/**
 * Tri, filtre et affinage des recherches côté manager
 */
Route::get('articcles/listedByMode', [App\Http\Controllers\ArticleController::class,'listedByMode'])->name('byMode');
Route::get('articcles/listedByType', [App\Http\Controllers\ArticleController::class,'listedByType'])->name('byType');
Route::get('articcles/listedByCouleur', [App\Http\Controllers\ArticleController::class,'listedByCouleur'])->name('byCouleur');
Route::get('articcles/listedByMarque', [App\Http\Controllers\ArticleController::class,'listedByMarque'])->name('byMarque');
Route::get('articcles/listedByTaille', [App\Http\Controllers\ArticleController::class,'listedByTaille'])->name('byTaille');
Route::post('articcles/listedByOneMode', [App\Http\Controllers\ArticleController::class,'listedByOneMode'])->name('byOneMode');
Route::post('articcles/listedByOneType', [App\Http\Controllers\ArticleController::class,'listedByOneType'])->name('byOneType');
Route::post('articcles/listedByOneCouleur', [App\Http\Controllers\ArticleController::class,'listedByOneCouleur'])->name('byOneCouleur');
Route::post('articcles/listedByOneMarque', [App\Http\Controllers\ArticleController::class,'listedByOneMarque'])->name('byOneMarque');
Route::post('articcles/listedByOneTaille', [App\Http\Controllers\ArticleController::class,'listedByOneTaille'])->name('byOneTaille');

/**
 * Gestion du panier :
 * * ajouter dans le panier
 * * * ajout de la quantité
 * * voir la liste des articles ajoutés dans le panier
 * * supprimer un du panier
 * * payé, enovoyer l'argent
 */
Route::post('panier',[\App\Http\Controllers\ArticleController::class,'remplirPanier'])->name('panier');
Route::get('livraison/liste',[\App\Http\Controllers\ArticleController::class,'ouvrirLivraison'])->name('livraison');

Route::get('panier/article/qte',[\App\Http\Controllers\PanierController::class,'ajouterQte'])->name('plusQte');
Route::get('panierMac/article/qte',[\App\Http\Controllers\PanierMacController::class,'ajouterQte'])->name('plusQteMac');

Route::get('panier/show',[\App\Http\Controllers\PanierMacController::class,'ouvrirPanier'])->name('panierMac');
Route::get('panier/show/user',[\App\Http\Controllers\PanierController::class,'ouvrirPanierUser'])->name('panierUser');

Route::delete('panier/delete/{article}',[\App\Http\Controllers\PanierMacController::class,'deletePanier'])->name('deletePanierMac');
Route::delete('panier/delete/{article}/user',[\App\Http\Controllers\PanierController::class,'deletePanierUser'])->name('deletePanierUser');

Route::get('panier/article/payer',[\App\Http\Controllers\AchatController::class,'validerPaiement'])->name('paiement');
Route::get('panierMac/article/payer',[\App\Http\Controllers\AchatMacController::class,'validerPaiement'])->name('paiementMac');

Route::get('livraison/livrer/{art}',[\App\Http\Controllers\LivraisonController::class,'livrer'])->name('livrer');
Route::get('livraisonMac/livrer/{art}',[\App\Http\Controllers\LivraisonMacController::class,'livrer'])->name('livrerMac');

Route::delete('livraison/delete/{article}/user',[\App\Http\Controllers\LivraisonController::class,'deleteLivraisonUser'])->name('deleteLivraisonUser');
Route::delete('livraisonMac/delete/{article}',[\App\Http\Controllers\LivraisonMacController::class,'deleteLivraison'])->name('deleteLivraison');