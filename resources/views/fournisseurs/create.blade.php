@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un fournisseur</h2>
    <br>
    <form method="POST" action="{{ route('fournisseurs.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control">
        </div>

        <div class="mb-3">
            <label>Note</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
