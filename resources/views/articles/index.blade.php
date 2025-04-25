@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📦 Liste des articles</h2>

    <!-- Barre de recherche -->
    <form method="GET" action="{{ route('articles.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Rechercher un article..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </div>
    </form>

    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">➕ Ajouter un article</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Référence</th>
                <th>Catégorie</th>
                <th>Fournisseur</th>
                <th>Stock</th>
                <th>Prix unitaire (FCFA)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr>
                <td>{{ $article->id }}</td>
                <td>{{ $article->designation }}</td>
                <td>{{ $article->reference }}</td>
                <td>{{ $article->categorie->nom ?? '-' }}</td>
                <td>{{ $article->fournisseur->nom ?? '-' }}</td>
                <td>{{ $article->stock }}</td>
                <td>{{ number_format($article->prix_unitaire, 0, ',', ' ') }}</td>
                <td>
                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">✏️ Modifier</a>
                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Aucun article trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
