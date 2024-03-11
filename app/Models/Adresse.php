<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "nom",
        "numero",
        "quartier",
        "commune",
        "ref",
        "province_id"
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function province(){
        return $this->belongsTo(Province::class)->get();
    }
}
