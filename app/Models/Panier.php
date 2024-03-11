<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    public function article()
    {
        return $this->hasOne(Article::class,'id','article_id')->get();
    }

    public function mode()
    {
        return $this->hasOne(Mode::class,'id','mode_id')->get();
    }

    public function taille()
    {
        return $this->hasOne(Taille::class,'id','taille_id')->get();
    }

    public function couleur()
    {
        return $this->hasOne(Couleur::class,'id','couleur_id')->get();
    }

    public function acheteur()
    {
        return $this->belongsTo(User::class,'user_id','id')->get();
    }
}
