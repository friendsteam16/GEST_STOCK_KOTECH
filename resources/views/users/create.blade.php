@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Créer un nouvel utilisateur</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Rôle</label>
            <select name="role_id" class="form-select" required>
                <option value="">-- Choisir un rôle --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->nom }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Créer</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
