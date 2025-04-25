<?php

namespace App\Http\Controllers;

use App\Models\Sortie;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Exports\SortiesExport;
use App\Exports\ChiffreAffairesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SortieController extends Controller
{
    /**
     * Affiche la liste des sorties de stock
     */
    public function index(Request $request)
    {
        $query = Sortie::with('produit')->orderBy('date_sortie', 'desc');

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_sortie', [$request->date_debut, $request->date_fin]);
        }

        $sorties = $query->get();

        return view('sorties.index', compact('sorties'));
    }

    /**
     * Affiche le formulaire pour une nouvelle sortie
     */
    public function create()
    {
        $produits = Produit::all();
        return view('sorties.create', compact('produits'));
    }

    /**
     * Enregistre une nouvelle sortie
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'date_sortie' => 'nullable|date',
            'type_sortie' => 'required|string|max:50',
        ]);

        $produit = Produit::find($request->produit_id);
        if ($produit->quantite_stock < $request->quantite) {
            return redirect()->back()->withErrors(['quantite' => 'Stock insuffisant pour cette sortie.']);
        }

        Sortie::create([
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'date_sortie' => $request->date_sortie ?? now(),
            'type_sortie' => $request->type_sortie,
        ]);

        $produit->quantite_stock -= $request->quantite;
        $produit->save();
        $sorties = Sortie::with('produit')->get();


        return redirect()->route('sorties.index')->with('success', 'Sortie enregistrée avec succès.');
    }

    /**
     * Export en PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Sortie::with('produit')->orderBy('date_sortie', 'desc');

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_sortie', [$request->date_debut, $request->date_fin]);
        }

        $sorties = $query->get();
        $pdf = Pdf::loadView('sorties.pdf', compact('sorties'));

        return $pdf->download('liste_sorties.pdf');
    }

    /**
     * Export Excel des sorties
     */
    public function exportExcel(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        return Excel::download(new SortiesExport($dateDebut, $dateFin), 'sorties.xlsx');
    }

    /**
     * Export du chiffre d'affaires
     */
    public function exportChiffreAffaires(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        return Excel::download(new ChiffreAffairesExport($dateDebut, $dateFin), 'chiffre_affaires.xlsx');
    }
}
