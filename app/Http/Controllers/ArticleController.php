<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Fournisseur;

class ArticleController extends Controller
{
    /**
     * Affiche la liste des articles.
     */
    public function index(Request $request)
    {
        $query = Article::with(['categorie', 'fournisseur']);

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('designation', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->get();

        return view('articles.index', compact('articles'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel article.
     */
    public function create()
    {
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('articles.create', compact('categories', 'fournisseurs'));
    }

    /**
     * Enregistre un nouvel article dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|max:255',
            'reference' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prix_unitaire' => 'nullable|numeric|min:0',
            'categorie_id' => 'nullable|exists:categories,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
        ]);

        Article::create($request->all());

        return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un article.
     */
    public function edit(Article $article)
    {
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('articles.edit', compact('article', 'categories', 'fournisseurs'));
    }

    /**
     * Met à jour un article existant.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'designation' => 'required|string|max:255',
            'reference' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'prix_unitaire' => 'nullable|numeric|min:0',
            'categorie_id' => 'nullable|exists:categories,id',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
        ]);

        $article->update($request->all());

        return redirect()->route('articles.index')->with('success', 'Article modifié avec succès.');
    }

    /**
     * Supprime un article.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }
}
