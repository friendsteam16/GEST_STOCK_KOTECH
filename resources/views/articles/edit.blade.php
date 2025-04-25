@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">✏️ Modifier l’article</h2>

    <form method="POST" action="{{ route('articles.update', $article->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="designation" class="form-label">Désignation</label>
            <input type="text" class="form-control" name="designation" value="{{ $article->designation }}" required>
        </div>

        <div class="mb-3">
            <label for="reference" class="form-label">Référence</label>
            <input type="text" class="form-control" name="reference" value="{{ $article->reference }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3">{{ $article->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" value="{{ $article->stock }}">
        </div>

        <div class="mb-3">
            <label for="prix_unitaire" class="form-label">Prix unitaire (FCFA)</label>
            <input type="number" class="form-control" name="prix_unitaire" step="0.01" value="{{ $article->prix_unitaire }}">
        </div>

        <!-- Sélecteur de catégorie -->
        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="form-select">
                <option value="">-- Choisir une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sélecteur de fournisseur -->
        <div class="mb-3">
            <label for="fournisseur_id" class="form-label">Fournisseur</label>
            <select name="fournisseur_id" id="fournisseur_id" class="form-select">
                <option value="">-- Choisir un fournisseur --</option>
                @foreach($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">✅ Mettre à jour</button>
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">↩️ Retour</a>
    </form>
</div>
@endsection
