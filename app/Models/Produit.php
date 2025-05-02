<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'code',
        'categorie',
        'quantite_stock',
        'prix_achat',
        'prix_vente',
        'seuil_alerte',
        'description',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
