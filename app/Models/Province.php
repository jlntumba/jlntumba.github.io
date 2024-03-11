<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom",
        "code",
        "superficie",
        "pays_id"
    ];

    public function pays(){
        return $this->belongsTo(Pays::class)->get();
    }
}
