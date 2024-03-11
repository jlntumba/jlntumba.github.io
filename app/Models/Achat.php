<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achat extends Model
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
        'pathImg',
        'marque',
        'mode',
        'type',
        'tailles',
        'qte',
        'datePaiement',
    ];

    public function marchand()
    {
        return $this->belongsTo(User::class,'marchand','id')->get();
    }

    public function acheteur()
    {
        return $this->belongsTo(User::class,'acheteur','id')->get();
    }
}
