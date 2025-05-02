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
        $request->validate([
            'nom' => 'required|string',
            'contact' => 'nullable|string',
            'email' => 'nullable|email',
            'adresse' => 'nullable|string',
            'note' => 'nullable|string',
        ]);
    
        Fournisseur::create($request->only('nom', 'contact', 'email', 'adresse', 'note'));
    
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur ajouté avec succès.');
    }

    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $validated = $request->validate([
            'nom'     => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email'   => 'nullable|email|max:255',
            'adresse' => 'nullable|string|max:255',
            'note'    => 'nullable|string',
        ]);
    
        $fournisseur->update($validated);
    
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour.');
    }
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé.');
    }

    
}
