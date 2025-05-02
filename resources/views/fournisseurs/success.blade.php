@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">Fournisseur bien enregistré !</h2>
    <br>
    <p><strong>Nom :</strong> {{ $fournisseur['nom'] }}</p>
    <p><strong>Contact :</strong> {{ $fournisseur['contact'] }}</p>
    <p><strong>Email :</strong> {{ $fournisseur['email'] }}</p>
    <p><strong>Adresse :</strong> {{ $fournisseur['adresse'] }}</p>
    <p><strong>Note :</strong> {{ $fournisseur['note'] }}</p>

    <a href="{{ route('fournisseurs.create') }}" class="btn btn-primary mt-3">Ajouter un autre</a>
</div>
@endsection
