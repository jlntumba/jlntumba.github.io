<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Middleware\TrustHosts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entreprise',
        'name',
        'postnom',
        'prenom',
        'sexe',
        'tel',
        'code',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adresse(){
        return $this->belongsTo(Adresse::class)->get();
    }

    public function roles(){
        return $this->belongsToMany(Role::class,'user_roles')->get();
    }

    public function marchandise(){
        return $this->hasMany(Article::class,"marchand","id")->get();
    }

    public function articlesAjoutes(){
        return $this->belongsToMany(Article::class,'paniers')->get();
    }

    public function articlesAchetes(){
        return $this->hasMany(Achat::class,'acheteur','id')->get();
    }

    public function articlesRecus(){
        return $this->hasMany(Livraison::class,'acheteur','id')->get();
    }

    public function paniers(){
        return $this->hasMany(Panier::class)->get();
    }

    public function articlesVendusAuth(){
        return $this->hasMany(Achat::class,'marchand','id')->get();
    }

    public function articlesVendusMac(){
        return $this->hasMany(AchatMac::class,'marchand','id')->get();
    }

    public function articlesVendus(){
        $articles = collect();
        $articlesAuth = $this->articlesVendusAuth();
        $articlesMac = $this->articlesVendusMac();

        foreach ($articlesAuth as $article) {
            $articles->push($article);
        }

        foreach ($articlesMac as $article) {
            $articles->push($article);
        }

        return $articles;
    }

    public function articlesLivresAuth(){
        return $this->hasMany(Livraison::class,'marchand','id')->get();
    }

    public function articlesLivresMac(){
        return $this->hasMany(LivraisonMac::class,'marchand','id')->get();
    }

    public function articlesLivres(){
        $articles = collect();
        $articlesAuth = $this->articlesLivresAuth();
        $articlesMac = $this->articlesLivresMac();

        foreach ($articlesAuth as $article) {
            $articles->push($article);
        }

        foreach ($articlesMac as $article) {
            $articles->push($article);
        }

        return $articles;
    }
}
