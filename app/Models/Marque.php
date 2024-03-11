<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'marque',
    ];

    public function articles(){
        return $this->hasMany(Article::class)->get();
    }

    public function type(){
        return $this->belongsTo(Type::class)->get();
    }
}
