@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📇 Fournisseurs</h2>
    <br>
    <a href="{{ route('fournisseurs.create') }}" class="btn btn-success mb-3">➕ Ajouter un fournisseur</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fournisseurs as $f)
            <tr>
                <td>{{ $f->id }}</td>
                <td>{{ $f->nom }}</td>
                <td>{{ $f->contact }}</td>
                <td>{{ $f->email }}</td>
                <td>{{ $f->adresse }}</td>
                <td>
                    <a href="{{ route('fournisseurs.edit', $f->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('fournisseurs.destroy', $f->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce fournisseur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
