<?php

namespace App\Exports;

use App\Models\Entree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EntreesExport implements FromCollection, WithHeadings
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
        $query = Entree::with('produit')->orderBy('date_entree', 'desc');

        if ($this->dateDebut && $this->dateFin) {
            $query->whereBetween('date_entree', [$this->dateDebut, $this->dateFin]);
        }

        return $query->get()->map(function ($entree) {
            return [
                'ID' => $entree->id,
                'Produit' => $entree->produit->nom ?? '',
                'Quantité' => $entree->quantite,
                'Date d\'entrée' => $entree->date_entree,
                'Source' => $entree->source ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['#', 'Produit', 'Quantité', 'Date d\'entrée', 'Source'];
    }
}
