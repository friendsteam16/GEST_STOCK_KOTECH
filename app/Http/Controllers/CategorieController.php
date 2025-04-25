<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;


class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|unique:categories',
        ]);

        Categorie::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée.');
    }

    public function edit(Categorie $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Categorie $category)
    {
        $request->validate([
            'nom' => 'required|unique:categories,nom,' . $category->id,
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour.');
    }

    public function destroy(Categorie $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée.');
    }
}
