<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques {{ $annee }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Statistiques mensuelles - {{ $annee }}</h2>
    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Entrées</th>
                <th>Sorties</th>
            </tr>
        </thead>
        <tbody>
            @foreach($moisLabels as $index => $mois)
                <tr>
                    <td>{{ $mois }}</td>
                    <td>{{ $entreeData[$index] }}</td>
                    <td>{{ $sortieData[$index] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
