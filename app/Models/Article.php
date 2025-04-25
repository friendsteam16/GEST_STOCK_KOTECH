<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'designation',
        'reference',
        'description',
        'stock',
        'prix_unitaire',
        'categorie_id',
        'fournisseur_id',
    ];
    
    // Relation avec la catégorie
    public function categorie()
    {
        return $this->belongsTo(\App\Models\Categorie::class);
    }
    
    // Relation avec le fournisseur
    public function fournisseur()
    {
        return $this->belongsTo(\App\Models\Fournisseur::class);
    }
    
    
}
