@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h2>

    <div class="row g-4">
        <!-- Total Produits -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box fs-1 mb-2"></i>
                    <h5 class="card-title">Produits</h5>
                    <p class="card-text fs-4">{{ $totalProduits }}</p>
                </div>
            </div>
        </div>

        <!-- Stock total -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow h-100">
                <div class="card-body text-center">
                    <i class="bi bi-archive fs-1 mb-2"></i>
                    <h5 class="card-title">Stock total</h5>
                    <p class="card-text fs-4">{{ $stockTotal }} articles</p>
                </div>
            </div>
        </div>

        <!-- Entrées -->
        <div class="col-md-3">
            <div class="card text-white bg-info shadow h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-down-square fs-1 mb-2"></i>
                    <h5 class="card-title">Total entrées</h5>
                    <p class="card-text fs-4">{{ $totalEntrees }}</p>
                </div>
            </div>
        </div>

        <!-- Sorties -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow h-100">
                <div class="card-body text-center">
                    <i class="bi bi-arrow-up-square fs-1 mb-2"></i>
                    <h5 class="card-title">Total sorties</h5>
                    <p class="card-text fs-4">{{ $totalSorties }}</p>
                </div>
            </div>
        </div>

        <!-- Chiffre d’affaires -->
        <div class="col-md-6">
            <div class="card text-white bg-danger shadow h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line fs-1 mb-2"></i>
                    <h5 class="card-title">Chiffre d’affaires</h5>
                    <p class="card-text fs-4">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire d’export -->
    <div class="card mt-4">
        <div class="card-body">
            <h5>📤 Export du chiffre d'affaires (par période)</h5>
            <form action="{{ route('chiffre.export.excel') }}" method="GET" class="row g-3 mt-2">
                <div class="col-md-4">
                    <input type="date" name="date_debut" class="form-control" placeholder="Date de début" required>
                </div>
                <div class="col-md-4">
                    <input type="date" name="date_fin" class="form-control" placeholder="Date de fin" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-file-earmark-excel"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
    <div class="card-body">
        <h5 class="mb-3"><i class="bi bi-graph-up-arrow me-2"></i>Statistiques d’entrées/sorties</h5>

        <div class="row mb-3">
            <div class="col-md-4">
                <select id="typeGraphique" class="form-select">
                    <option value="mois">Mensuel</option>
                    <option value="annee">Annuel</option>
                </select>
            </div>
        </div>

        <canvas id="stockChart" height="100"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('stockChart').getContext('2d');

        const moisLabels = @json($moisLabels);
        const entreeData = @json($entreeData);
        const sortieData = @json($sortieData);

        // Valeurs annuelles simulées (tu peux adapter depuis le contrôleur plus tard)
        const annees = ["2022", "2023", "2024"];
        const entreesAnnuelles = [1200, 950, 1300];
        const sortiesAnnuelles = [1000, 870, 1250];

        let currentChart;

        function renderChart(labels, data1, data2) {
            if (currentChart) currentChart.destroy();

            currentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Entrées',
                            data: data1,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        },
                        {
                            label: 'Sorties',
                            data: data2,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Statistiques des entrées et sorties'
                        }
                    }
                }
            });
        }

        // Initialisation par défaut en mode "mois"
        renderChart(moisLabels, entreeData, sortieData);

        // Changer selon la sélection
        document.getElementById('typeGraphique').addEventListener('change', function () {
            const type = this.value;

            if (type === 'mois') {
                renderChart(moisLabels, entreeData, sortieData);
            } else {
                renderChart(annees, entreesAnnuelles, sortiesAnnuelles);
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@endsection
