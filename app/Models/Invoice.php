<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['sortie_id','client_name','apply_tva'];

    public function sortie()
    {
        return $this->belongsTo(Sortie::class);
    }
}

