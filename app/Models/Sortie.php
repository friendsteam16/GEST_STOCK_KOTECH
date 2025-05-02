<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sortie extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite',
        'date_sortie',
        'type_sortie',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

}
