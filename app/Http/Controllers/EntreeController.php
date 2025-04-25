<?php

namespace App\Http\Controllers;

use App\Models\Entree;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EntreesExport; // tu dois créer cette classe
use Maatwebsite\Excel\Facades\Excel;

class EntreeController extends Controller
{
    /**
     * Affiche la liste des entrées.
     */
    public function index(Request $request)
    {
        $query = Entree::with('produit')->orderBy('date_entree', 'desc');

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_entree', [$request->date_debut, $request->date_fin]);
        }

        $entrees = $query->get();

        return view('entrees.index', compact('entrees'));
    }

    /**
     * Affiche le formulaire de création d'une entrée.
     */
    public function create()
    {
        $produits = Produit::all();
        return view('entrees.create', compact('produits'));
    }

    /**
     * Enregistre une nouvelle entrée.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'date_entree' => 'nullable|date',
            'source' => 'nullable|string|max:255',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        // Création de l’entrée
        Entree::create([
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'date_entree' => $request->date_entree ?? now(),
            'source' => $request->source,
        ]);

        // Mise à jour du stock
        $produit->quantite_stock += $request->quantite;
        $produit->save();

        return redirect()->route('entrees.index')->with('success', 'Entrée enregistrée avec succès.');
    }

    /**
     * Export PDF des entrées filtrées.
     */
    public function exportPdf(Request $request)
    {
        $query = Entree::with('produit')->orderBy('date_entree', 'desc');

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_entree', [$request->date_debut, $request->date_fin]);
        }

        $entrees = $query->get();

        $pdf = Pdf::loadView('entrees.pdf', compact('entrees'));
        return $pdf->download('liste_entrees.pdf');
    }

    /**
     * Export Excel des entrées filtrées.
     */
    public function exportExcel(Request $request)
    {
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');

        return Excel::download(new EntreesExport($dateDebut, $dateFin), 'entrees.xlsx');
    }
}
