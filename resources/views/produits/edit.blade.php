@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ Modifier le produit</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produits.update', $produit->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $produit->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" value="{{ $produit->code }}" required>
        </div>

        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie</label>
            <input type="text" name="categorie" class="form-control" value="{{ $produit->categorie }}">
        </div>

        <div class="mb-3">
            <label for="quantite_stock" class="form-label">Quantité en stock</label>
            <input type="number" name="quantite_stock" class="form-control" value="{{ $produit->quantite_stock }}">
        </div>

        <div class="mb-3">
            <label for="prix_achat" class="form-label">Prix d'achat</label>
            <input type="number" name="prix_achat" class="form-control" value="{{ $produit->prix_achat }}">
        </div>

        <div class="mb-3">
            <label for="prix_vente" class="form-label">Prix de vente</label>
            <input type="number" name="prix_vente" class="form-control" value="{{ $produit->prix_vente }}">
        </div>

        <div class="mb-3">
            <label for="seuil_alerte" class="form-label">Seuil d'alerte</label>
            <input type="number" name="seuil_alerte" class="form-control" value="{{ $produit->seuil_alerte }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $produit->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('produits.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
