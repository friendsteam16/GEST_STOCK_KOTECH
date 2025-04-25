@extends('layouts.app')

@section('content')
<div class="container mt-4">

    @if(isset($stockBas) && count($stockBas) > 0)
            <div class="alert alert-danger shadow mb-4">
                <h5><i class="fas fa-exclamation-triangle"></i> Attention : Produits en rupture de stock</h5>
                <ul class="mb-0">
                    @foreach($stockBas as $produit)
                        <li>{{ $produit->nom }} ({{ $produit->quantite_stock }} en stock)</li>
                    @endforeach
                </ul>
            </div>
    @endif

        <!-- Titre -->


    <!-- Cartes résumé améliorées -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-gradient shadow-sm border-0 card-hover bg-primary">
                <div class="card-body text-center">
                    <i class="fas fa-boxes fa-2x mb-3"></i>
                    <h5 class="card-title">Produits</h5>
                    <p class="fs-4 mb-0">{{ $totalProduits ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-gradient shadow-sm border-0 card-hover bg-success">
                <div class="card-body text-center">
                    <i class="fas fa-cubes fa-2x mb-3"></i>
                    <h5 class="card-title">Stock total</h5>
                    <p class="fs-4 mb-0">{{ $stockTotal ?? 0 }} articles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-gradient shadow-sm border-0 card-hover bg-info">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down fa-2x mb-3"></i>
                    <h5 class="card-title">Total entrées</h5>
                    <p class="fs-4 mb-0">{{ $totalEntrees ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-gradient shadow-sm border-0 card-hover bg-warning">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-up fa-2x mb-3"></i>
                    <h5 class="card-title">Total sorties</h5>
                    <p class="fs-4 mb-0">{{ $totalSorties ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte chiffre d'affaires -->
    <div class="card text-white bg-danger bg-gradient mb-4 border-0 shadow-sm text-center card-hover">
        <div class="card-body">
            <i class="fas fa-coins fa-2x mb-3"></i>
            <h5>Chiffre d’affaires</h5>
            <p class="fs-3 fw-bold mb-0">{{ number_format($chiffreAffaires ?? 0, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <!-- Export chiffre d'affaires -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3"><i class="fas fa-file-excel text-success"></i> Export du chiffre d’affaires (par période)</h5>
            <form action="{{ route('chiffre.export.excel') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label>Date de début</label>
                    <input type="date" name="date_debut" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label>Date de fin</label>
                    <input type="date" name="date_fin" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-download"></i> Exporter en Excel
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Graphique -->

    <div class="card mb-5">
        <div class="card-body">
            <h5 class="mb-3"><i class="fas fa-chart-bar text-primary"></i> Évolution des entrées et sorties par mois</h5>
            <canvas id="evolutionChart" height="100"></canvas>
        </div>
    </div>

</div>

<form method="GET" action="{{ route('dashboard') }}" class="mb-3">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="annee">Filtrer par année :</label>
            <select name="annee" class="form-select w-auto d-inline" onchange="this.form.submit()">
                @foreach (range(date('Y'), 2020) as $year)
                    <option value="{{ $year }}" {{ request('annee', now()->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            <!-- Nouveau bouton PDF -->
            <a href="{{ route('dashboard.export.pdf', ['annee' => request('annee', now()->year)]) }}" class="btn btn-danger mt-3">
                <i class="fas fa-file-pdf"></i> Exporter en PDF
            </a> 
        </div>
    </div>
</form>
    <!-- Export du graphique -->
    <button onclick="exportChart()" class="btn btn-outline-secondary mt-3">
        <i class="fas fa-download"></i> Exporter le graphique
    </button>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('evolutionChart').getContext('2d');
    const evolutionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($moisLabels) !!},
            datasets: [
                {
                    label: 'Entrées',
                    data: {!! json_encode($entreeData) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.6)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Sorties',
                    data: {!! json_encode($sortieData) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.6)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Tendance Entrées',
                    data: {!! json_encode($entreeData) !!},
                    type: 'line',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    });
</script>


<script>
    function exportChart() {
        const link = document.createElement('a');
        link.download = 'graphique-entrées-sorties.png';
        link.href = document.getElementById('evolutionChart').toDataURL();
        link.click();
    }
</script>
<style>
    .card {
        opacity: 1 !important;
        transition: all 0.3s ease-in-out;
    }
    .card .card-body {
        color: white;
    }
</style>



@endsection
