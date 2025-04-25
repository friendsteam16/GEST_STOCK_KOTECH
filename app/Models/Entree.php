<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entree extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite',
        'date_entree',
        'source',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
