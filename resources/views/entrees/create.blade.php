@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white">
            <h4><i class="fas fa-arrow-down"></i> Nouvelle entrée de stock</h4>
        </div>

        <div class="card-body">
            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('entrees.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="produit_id" class="form-label">Produit <span class="text-danger">*</span></label>
                    <select name="produit_id" id="produit_id" class="form-select" required>
                        <option value="">-- Sélectionner un produit --</option>
                        @foreach($produits as $produit)
                            <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                {{ $produit->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité <span class="text-danger">*</span></label>
                    <input type="number" name="quantite" id="quantite" class="form-control" min="1" value="{{ old('quantite') }}" required>
                </div>

                <div class="mb-3">
                    <label for="date_entree" class="form-label">Date d'entrée</label>
                    <input type="date" name="date_entree" id="date_entree" class="form-control" value="{{ old('date_entree') }}">
                </div>

                <div class="mb-3">
                    <label for="source" class="form-label">Source (facultatif)</label>
                    <input type="text" name="source" id="source" class="form-control" value="{{ old('source') }}">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('entrees.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
