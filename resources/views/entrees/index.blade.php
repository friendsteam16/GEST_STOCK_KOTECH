@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">
        <i class="fas fa-arrow-down text-success"></i> Liste des entrées de stock
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Zone de boutons -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <a href="{{ route('entrees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter une entrée
        </a>
        <div class="btn-group">
            <a href="{{ route('entrees.export.pdf', request()->only(['date_debut', 'date_fin'])) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Exporter en PDF
            </a>
            <a href="{{ route('entrees.export.excel', request()->only(['date_debut', 'date_fin'])) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exporter en Excel
            </a>
        </div>
    </div>

    <!-- Formulaire de filtrage -->
    <div class="card mb-4">
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
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                    <a href="{{ route('entrees.index') }}" class="btn btn-secondary">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau -->
    @if($entrees->isEmpty())
        <div class="alert alert-warning text-center">
            Aucune entrée enregistrée pour l'instant.
        </div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Date d'entrée</th>
                    <th>Source</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entrees as $entree)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $entree->produit->nom }}</td>
                        <td>{{ $entree->quantite }}</td>
                        <td>{{ \Carbon\Carbon::parse($entree->date_entree)->format('d/m/Y H:i') }}</td>
                        <td>{{ $entree->source ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
