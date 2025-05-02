@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ Ajouter un nouveau produit</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produits.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom du produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code produit</label>
            <input type="text" name="code" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select name="categorie_id" class="form-select" required>
                <option value="">-- Sélectionner --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="quantite_stock" class="form-label">Quantité initiale</label>
            <input type="number" name="quantite_stock" class="form-control">
        </div>

        <div class="mb-3">
            <label for="prix_achat" class="form-label">Prix d'achat</label>
            <input type="number" name="prix_achat" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="prix_vente" class="form-label">Prix de vente</label>
            <input type="number" name="prix_vente" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label for="seuil_alerte" class="form-label">Seuil d'alerte</label>
            <input type="number" name="seuil_alerte" class="form-control">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
