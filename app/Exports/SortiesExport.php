<?php

namespace App\Exports;

use App\Models\Sortie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SortiesExport implements FromCollection, WithHeadings
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
        $query = Sortie::with('produit')->orderBy('date_sortie', 'desc');

        if ($this->dateDebut && $this->dateFin) {
            $query->whereBetween('date_sortie', [$this->dateDebut, $this->dateFin]);
        }

        return $query->get()->map(function ($sortie) {
            return [
                'ID' => $sortie->id,
                'Produit' => $sortie->produit->nom ?? '',
                'Quantité' => $sortie->quantite,
                'Date de sortie' => $sortie->date_sortie,
                'Type de sortie' => $sortie->type_sortie ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['#', 'Produit', 'Quantité', 'Date de sortie', 'Type de sortie'];
    }
}
