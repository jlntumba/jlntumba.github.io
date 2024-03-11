<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
    ];

    public function articles(){
        return $this->hasMany(Article::class)->get();
    }

    public function marques(){
        return $this->hasMany(Marque::class)->get();
    }
}