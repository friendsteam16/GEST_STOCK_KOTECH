<?php

namespace App\Exports;

use App\Models\Sortie;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ChiffreAffairesExport implements FromCollection, WithHeadings
{
    protected $dateDebut;
    protected $dateFin;

    public function __construct($dateDebut = null, $dateFin = null)
    {
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
    }

    public function collection()
    {
        $query = Sortie::select(
                'produits.nom as produit',
                'produits.prix_vente',
                DB::raw('SUM(sorties.quantite) as quantite_total'),
                DB::raw('SUM(sorties.quantite * produits.prix_vente) as total')
            )
            ->join('produits', 'sorties.produit_id', '=', 'produits.id')
            ->groupBy('produits.nom', 'produits.prix_vente');

        if ($this->dateDebut && $this->dateFin) {
            $query->whereBetween('date_sortie', [$this->dateDebut, $this->dateFin]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Produit',
            'Prix unitaire (FCFA)',
            'Quantité totale vendue',
            'Chiffre d\'affaires (FCFA)',
        ];
    }
}
