<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taille extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'taille',
    ];


    public function articles(){
        return $this->belongsToMany(Article::class,'article_tailles')->get();
    }

    public function paniers(){
        return $this->hasMany(Panier::class)->get();
    }

    public function paniersMac(){
        return $this->hasMany(PanierMac::class)->get();
    }
}
