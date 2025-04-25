<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>📤 Liste des sorties de stock</h2>

    <table>
        <thead>
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
                    <td>{{ \Carbon\Carbon::parse($sortie->date_sortie)->format('d/m/Y H:i') }}</td>
                    <td>{{ ucfirst($sortie->type_sortie) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
