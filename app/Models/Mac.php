<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mac extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mac'
    ];

    public function articlesAjoutes(){
        return $this->belongsToMany(Article::class,'panier_macs','mac')->get();
    }

    public function articlesAchetes(){
        return $this->hasMany(AchatMac::class,'mac','mac')->get();
    }

    public function articlesRecus(){
        return $this->hasMany(LivraisonMac::class,'mac','mac')->get();
    }

    public function paniersMac(){
        return $this->hasMany(PanierMac::class)->get();
    }
}
