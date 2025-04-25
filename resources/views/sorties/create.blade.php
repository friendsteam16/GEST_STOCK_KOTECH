@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nouvelle sortie de stock</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sorties.store') }}" method="POST">
        @csrf

        <!-- Produit -->
        <div class="mb-3">
            <label for="produit_id">Produit</label>
            <select name="produit_id" id="produit_id" required class="form-select">
                <option value="">-- Choisir un produit --</option>
                @foreach($produits as $produit)
                    <option value="{{ $produit->id }}">{{ $produit->nom }} (Stock: {{ $produit->quantite_stock }})</option>
                @endforeach
            </select>
        </div>

        <!-- Quantité -->
        <div class="mb-3">
            <label for="quantite">Quantité</label>
            <input type="number" name="quantite" class="form-control" required>
        </div>

        <!-- Date de sortie -->
        <div class="mb-3">
            <label for="date_sortie">Date de sortie</label>
            <input type="datetime-local" name="date_sortie" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>

        <!-- Type de sortie -->
        <div class="mb-3">
            <label for="type_sortie">Type de sortie</label>
            <select name="type_sortie" class="form-select" required>
                <option value="vente">Vente</option>
                <option value="perte">Perte</option>
                <option value="don">Don</option>
                <option value="autre">Autre</option>
            </select>
        </div>

        <button type="submit" class="btn btn-danger">Enregistrer la sortie</button>
    </form>
</div>
@endsection
