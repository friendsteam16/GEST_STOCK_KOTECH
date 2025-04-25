<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FournisseurController extends Controller
{
    public function index()
    {
    
        $fournisseurs = Fournisseur::all();
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    public function create()
    {
    
        return view('fournisseurs.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
        try {
            // Logique de création du fournisseur
            dd($request->all());
            Fournisseur::create($request->validated());
            return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du fournisseur : ' . $e->getMessage());
            return back()->withErrors(['error' => 'Une erreur est survenue.']);
        }
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $fournisseur->update($request->all());
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour.');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé.');
    }

    
}
