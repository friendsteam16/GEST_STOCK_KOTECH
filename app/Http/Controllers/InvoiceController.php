<?php
namespace App\Http\Controllers;

use App\Models\Sortie;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Affiche le formulaire prérempli
    public function create(Sortie $sortie)
    {
        // Si la facture existe déjà, tu peux la charger ou empêcher la recréation
        return view('invoices.create', compact('sortie'));
    }

    // Enregistre la facture et génère le PDF
    public function store(Request $request, Sortie $sortie)
    {
        $data = $request->validate([
            'client_name'   => 'required|string',
            'apply_tva'     => 'nullable|boolean',
        ]);

        // Crée ou met à jour la facture liée
        $invoice = Invoice::updateOrCreate(
            ['sortie_id' => $sortie->id],
            [
              'client_name' => $data['client_name'],
              'apply_tva'   => $request->has('apply_tva'),
            ]
        );

        // Prépare les données pour le PDF
        $lines = [[
           'desc'  => $sortie->produit->nom,
           'qty'   => $sortie->quantite,
           'unit'  => $sortie->produit->prix_vente,
           'total' => $sortie->produit->prix_vente * $sortie->quantite,
        ]];

        $subtotal = $lines[0]['total'];
        $tvaRate  = $invoice->apply_tva ? 0.18 : 0;
        $tva      = $subtotal * $tvaRate;
        $totalTTC = $subtotal + $tva;

        $pdf = Pdf::loadView('invoices.invoice', [
          'clientName' => $invoice->client_name,
          'lines'      => $lines,
          'subtotal'   => $subtotal,
          'tva'        => $tva,
          'totalTTC'   => $totalTTC,
          'tvaRate'    => $tvaRate * 100,
          'reference'  => 'INV-' . str_pad($invoice->id, 6, '0', STR_PAD_LEFT),
          'date'       => now()->format('d/m/Y'),
        ])->setPaper('a4','portrait');

        return $pdf->stream($invoice->reference . '.pdf');
    }
}
