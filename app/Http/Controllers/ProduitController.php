<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(Request $request)
    {
        $query = Produit::query()->orderBy('created_at', 'desc');

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
        }

        $produits = $query->get();

        return view('produits.index', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all(); // Récupère toutes les catégories
        return view('produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|unique:produits',
            'quantite_stock' => 'nullable|integer',
            'prix_achat' => 'nullable|numeric',
            'prix_vente' => 'nullable|numeric',
        ]);

        Produit::create($request->all());

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès');
    }

    public function edit(Produit $produit)
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|unique:produits,code,' . $produit->id,
        ]);

        $produit->update($request->all());

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès');
        return view('produits.index', compact('produits', 'seuil_alerte'));
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès');
    }
}
