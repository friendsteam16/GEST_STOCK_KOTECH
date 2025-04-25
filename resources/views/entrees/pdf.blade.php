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
    <h2>📥 Liste des entrées de stock</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Date d'entrée</th>
                <th>Source</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entrees as $entree)
                <tr>
                    <td>{{ $entree->id }}</td>
                    <td>{{ $entree->produit->nom }}</td>
                    <td>{{ $entree->quantite }}</td>
                    <td>{{ \Carbon\Carbon::parse($entree->date_entree)->format('d/m/Y H:i') }}</td>
                    <td>{{ $entree->source ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
