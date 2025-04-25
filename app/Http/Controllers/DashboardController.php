<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Produit;
use App\Models\Entree;
use App\Models\Sortie;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf; // Assure-toi d’avoir ce use en haut

class DashboardController extends Controller
{
    public function index()
    {

        $annee = request('annee', date('Y'));

        $dataEntreeMois = DB::table('entrees')
            ->whereYear('date_entree', $annee)
            ->select(DB::raw('MONTH(date_entree) as mois'), DB::raw('SUM(quantite) as total'))
            ->groupBy(DB::raw('MONTH(date_entree)'))
            ->orderBy('mois')
            ->get();
        
        $dataSortieMois = DB::table('sorties')
            ->whereYear('date_sortie', $annee)
            ->select(DB::raw('MONTH(date_sortie) as mois'), DB::raw('SUM(quantite) as total'))
            ->groupBy(DB::raw('MONTH(date_sortie)'))
            ->orderBy('mois')
            ->get();
        
        

        $totalProduits = Produit::count();
        $stockTotal = Produit::sum('quantite_stock');
        $totalEntrees = Entree::sum('quantite');
        $totalSorties = Sortie::sum('quantite');

        $chiffreAffaires = DB::table('sorties')
            ->join('produits', 'produits.id', '=', 'sorties.produit_id')
            ->where('sorties.type_sortie', 'vente')
            ->sum(DB::raw('produits.prix_vente * sorties.quantite'));

        // Groupe les entrées par mois
        $dataEntreeMois = DB::table('entrees')
            ->select(DB::raw('MONTH(date_entree) as mois'), DB::raw('SUM(quantite) as total'))
            ->groupBy(DB::raw('MONTH(date_entree)'))
            ->orderBy('mois')
            ->get();

        $dataSortieMois = DB::table('sorties')
            ->select(DB::raw('MONTH(date_sortie) as mois'), DB::raw('SUM(quantite) as total'))
            ->groupBy(DB::raw('MONTH(date_sortie)'))
            ->orderBy('mois')
            ->get();

        $moisLabels = collect(range(1, 12))->map(function ($mois) {
            return Carbon::create()->month($mois)->locale('fr_FR')->isoFormat('MMMM');
        });

        $entreeData = array_fill(0, 12, 0);
        $sortieData = array_fill(0, 12, 0);

        foreach ($dataEntreeMois as $item) {
            $entreeData[$item->mois - 1] = $item->total;
        }

        foreach ($dataSortieMois as $item) {
            $sortieData[$item->mois - 1] = $item->total;
        }

        $stockBas = Produit::where('quantite_stock', '<', 10)->get();

        return view('dashboard.index', compact(
            'totalProduits',
            'stockTotal',
            'totalEntrees',
            'totalSorties',
            'chiffreAffaires',
            'moisLabels',
            'entreeData',
            'sortieData',
            'stockBas',
            'annee' // <--- Ne PAS mettre de virgule ici
        ));
        
    }

    public function exportPdf(Request $request)
    {
        $annee = $request->input('annee', now()->year);
        $dataEntreeMois = DB::table('entrees')
            ->select(DB::raw('MONTH(date_entree) as mois'), DB::raw('SUM(quantite) as total'))
            ->whereYear('date_entree', $annee)
            ->groupBy(DB::raw('MONTH(date_entree)'))
            ->orderBy('mois')
            ->get();

        $dataSortieMois = DB::table('sorties')
            ->select(DB::raw('MONTH(date_sortie) as mois'), DB::raw('SUM(quantite) as total'))
            ->whereYear('date_sortie', $annee)
            ->groupBy(DB::raw('MONTH(date_sortie)'))
            ->orderBy('mois')
            ->get();

        $moisLabels = collect(range(1, 12))->map(function ($mois) {
            return \Carbon\Carbon::create()->month($mois)->locale('fr')->translatedFormat('F');
        });

        $entreeData = array_fill(0, 12, 0);
        $sortieData = array_fill(0, 12, 0);

        foreach ($dataEntreeMois as $item) {
            $entreeData[$item->mois - 1] = $item->total;
        }

        foreach ($dataSortieMois as $item) {
            $sortieData[$item->mois - 1] = $item->total;
        }

        $pdf = Pdf::loadView('dashboard.export_pdf', [
            'moisLabels' => $moisLabels,
            'entreeData' => $entreeData,
            'sortieData' => $sortieData,
            'annee' => $annee
        ]);

        return $pdf->download("statistiques_$annee.pdf");
    }

}


    



