@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📦 Liste des produits</h2>

    <div class="mb-3">
        <a href="{{ route('produits.create') }}" class="btn btn-success">➕ Ajouter un produit</a>
    </div>

    <!-- Formulaire de filtrage par date -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-4">
                    <label>Date de début</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-4">
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                    <a href="{{ route('produits.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($produits->isEmpty())
        <p>Aucun produit trouvé.</p>
    @else
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Code</th>
                <th>Catégorie</th>
                <th>Prix achat</th>
                <th>Prix vente</th>
                <th>Stock actuel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produits as $produit)
            <tr>
                <td>{{ $produit->id }}</td>
                <td>{{ $produit->nom }}</td>
                <td>{{ $produit->code }}</td>
                <td>{{ $produit->categorie }}</td>
                <td>{{ number_format($produit->prix_achat, 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($produit->prix_vente, 0, ',', ' ') }} FCFA</td>
                <td>{{ $produit->quantite_stock }}</td>
                <td>
                    <a href="{{ route('produits.edit', $produit->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('produits.destroy', $produit->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
