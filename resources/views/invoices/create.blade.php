@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white rounded shadow">
  <h2 class="text-2xl mb-4">Facture pour la vente n°{{ $sortie->id }}</h2>

  <form action="{{ route('sorties.invoice.store', ['sortie' => $sortie->id]) }}" method="POST">
    @csrf

    <!-- Client -->
    <div class="mb-4">
      <label class="block font-medium">Nom du client</label>
      <input type="text" name="client_name" class="w-full border p-2" required>
    </div>

    <!-- TVA -->
    <div class="mb-4 flex items-center">
      <input type="hidden" name="apply_tva" value="0">
      <input type="checkbox" name="apply_tva" value="1" id="apply_tva" class="mr-2">
      <label for="apply_tva">Appliquer la TVA (18%)</label>
    </div>

    <!-- Aperçu de la ligne issue de la vente -->
    <div class="mb-4">
      <h3 class="font-semibold mb-2">Élément facturé</h3>
      <p><strong>Produit :</strong> {{ $sortie->produit->nom }}</p>
      <p><strong>Quantité :</strong> {{ $sortie->quantite }}</p>
      <p><strong>Prix unitaire :</strong> {{ number_format($sortie->produit->prix_vente,2,',',' ') }} €</p>
    </div>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
      Générer la facture PDF
    </button>
  </form>
</div>
@endsection
