<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'devise',
        'nbr',
        'pathImg',
    ];

    public function marchand(){
        return $this->belongsTo(User::class,"marchand","id")->get()[0];
    }
    
    public function marque(){
        return $this->belongsTo(Marque::class)->get();
    }

    public function type(){
        return $this->belongsTo(Type::class)->get()[0];
    }

    public function tailles(){
        return $this->belongsToMany(Taille::class,'article_tailles')->get();
    }

    public function modes(){
        return $this->belongsToMany(Mode::class,'article_modes')->get();
    }

    public function couleurs(){
        return $this->belongsToMany(Couleur::class,'article_couleurs')->get();
    }

    public function users(){
        return $this->belongsToMany(User::class,'paniers')->get();
    }

    public function macs(){
        return $this->belongsToMany(Mac::class,'panier_macs')->get();
    }
}
