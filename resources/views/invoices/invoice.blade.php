<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Facture</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background: #f0f0f0; }
    .text-right { text-align: right; }
    .header { text-align: center; margin-bottom: 20px; }
  </style>
</head>
<body>
  <div class="header">
    <h1>{{ config('app.name') }}</h1>
    <p>Facture adressée à : <strong>{{ $clientName }}</strong></p>
  </div>

  <table>
    <thead>
      <tr>
        <th>Désignation</th>
        <th>Quantité</th>
        <th>PU (Fcfa)</th>
        <th>Total (Fcfa)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($lines as $line)
      <tr>
        <td>{{ $line['desc'] }}</td>
        <td class="text-right">{{ $line['qty'] }}</td>
        <td class="text-right">{{ number_format($line['unit'],2,',',' ') }}</td>
        <td class="text-right">{{ number_format($line['total'],2,',',' ') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3" class="text-right"><strong>Sous-total HT</strong></td>
        <td class="text-right">{{ number_format($subtotal,2,',',' ') }}</td>
      </tr>
      <tr>
        <td colspan="3" class="text-right"><strong>TVA ({{ $tvaRate }}%)</strong></td>
        <td class="text-right">{{ number_format($tva,2,',',' ') }}</td>
      </tr>
      <tr>
        <td colspan="3" class="text-right"><strong>Total TTC</strong></td>
        <td class="text-right">{{ number_format($totalTTC,2,',',' ') }}</td>
      </tr>
    </tfoot>
  </table>
</body>
</html>
