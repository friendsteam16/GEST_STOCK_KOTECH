@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ Modifier le fournisseur</h2>
    <br>
    <form method="POST" action="{{ route('fournisseurs.update', $fournisseur->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $fournisseur->nom }}" required>
        </div>

        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" value="{{ $fournisseur->contact }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $fournisseur->email }}">
        </div>

        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" value="{{ $fournisseur->adresse }}">
        </div>

        <div class="mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control">{{ $fournisseur->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
