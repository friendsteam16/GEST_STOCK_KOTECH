@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📂 Catégories de produits</h2>

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">➕ Nouvelle catégorie</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->nom }}</td>
                    <td>{{ $cat->description }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
