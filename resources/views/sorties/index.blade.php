@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">📤 Liste des sorties de stock</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('sorties.create') }}" class="btn btn-danger">➖ Nouvelle sortie</a>
        </div>

        @if($sorties->isEmpty())
            <p>Aucune sortie enregistrée.</p>
        @else
        <table class="table table-bordered table-striped">
            <thead class="table-danger">
                <tr>
                    <th>#</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Date de sortie</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sorties as $sortie)
                    <tr>
                        <td>{{ $sortie->id }}</td>
                        <td>{{ $sortie->produit->nom }}</td>
                        <td>{{ $sortie->quantite }}</td>
                        <td>{{ $sortie->date_sortie }}</td>
                        <td>{{ $sortie->type_sortie }}</td>
                        <td>
                            <a href="{{ route('sorties.invoice.create', $sortie->id) }}"
                                class="btn btn-sm btn-primary">
                                📄 Facturer
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
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
                    <a href="{{ route('sorties.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>
    <a href="{{ route('sorties.export.pdf', request()->only(['date_debut', 'date_fin'])) }}" class="btn btn-danger">
        📄 Exporter en PDF
    </a>
    <a href="{{ route('sorties.export.excel', request()->only(['date_debut', 'date_fin'])) }}"
    class="btn btn-success">
        📊 Exporter en Excel
    </a>

    <form action="{{ route('chiffre.export.excel') }}" method="GET" class="row g-2">
        <div class="col-md-4">
            <input type="date" name="date_debut" class="form-control" placeholder="Date de début">
        </div>
        <div class="col-md-4">
            <input type="date" name="date_fin" class="form-control" placeholder="Date de fin">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">
                📈 Export CA en Excel
            </button>
        </div>
    </form>


@endsection
