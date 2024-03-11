<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchatMac extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'noms',
        'addrs',
        'tel',
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

    public function acheteur()
    {
        return $this->belongsTo(Mac::class,'mac','mac')->get();
    }

    public function marchand()
    {
        return $this->belongsTo(User::class,'marchand','id')->get();
    }
}
