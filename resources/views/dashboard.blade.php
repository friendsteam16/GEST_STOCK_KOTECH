@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-white text-2xl font-semibold mb-6"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Total Produits -->
        <div class="bg-blue-600 p-5 rounded-2xl shadow text-center text-white col-md-12 bg-primary shadow h-100">
            <i class="bi bi-box fs-1 text-4xl mb-2"></i>
            <div class="text-lg">Produits</div>
            <div class="text-2xl font-bold">{{ $totalProduits }}</div>
        </div>

        <!-- Stock total -->
        <div class="bg-green-600 p-5 rounded-2xl shadow text-center text-white col-md-12 bg-success shadow h-100">
            <i class="bi bi-archive fs-1 text-4xl mb-2"></i>
            <div class="text-lg">Stock total</div>
            <div class="text-2xl font-bold">{{ $stockTotal }} articles</div>
        </div>

        <!-- Entrées -->
        <div class="bg-cyan-600 p-5 rounded-2xl shadow text-center text-white col-md-12 bg-info shadow h-100">
            <i class="bi bi-arrow-down-square fs-1 text-4xl mb-2"></i>
            <div class="text-lg">Total entrées</div>
            <div class="text-2xl font-bold">{{ $totalEntrees }}</div>
        </div>

        <!-- Sorties -->
        <div class="bg-yellow-500 p-5 rounded-2xl shadow text-center text-white col-md-12 bg-warning shadow h-100">
            <i class="bi bi-arrow-up-square fs-1 text-4xl mb-2"></i>
            <div class="text-lg">Total sorties</div>
            <div class="text-2xl font-bold">{{ $totalSorties }}</div>
        </div>

        <!-- Chiffre d'affaires -->
        <div class="col-span-1 lg:col-span-2 bg-red-600 p-5 rounded-2xl shadow text-center text-white col-md-12">
            <i class="bi bi-bar-chart-line text-4xl mb-2"></i>
            <div class="text-lg">Chiffre d'affaires</div>
            <div class="text-2xl font-bold">{{ number_format($chiffreAffaires, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <!-- Formulaire d’export -->
    <div class="bg-gray-800 mt-10 p-6 rounded-xl shadow text-white">
        <h5 class="mb-4 text-xl font-semibold">Export du chiffre d'affaires (par période)</h5>
        <form action="{{ route('chiffre.export.excel') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="date" name="date_debut" class="form-input rounded p-2 text-black" required>
            <input type="date" name="date_fin" class="form-input rounded p-2 text-black" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>
        </form>
    </div>

    <!-- Graphique -->
    <div class="bg-gray-800 mt-10 p-6 rounded-xl shadow text-white">
        <h5 class="text-xl font-semibold mb-3"><i class="bi bi-graph-up-arrow me-2"></i>Statistiques d’entrées/sorties</h5>
        <div class="mb-4">
            <select id="typeGraphique" class="form-select bg-gray-700 text-white">
                <option value="mois">Mensuel</option>
                <option value="annee">Annuel</option>
            </select>
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
                        { label: 'Entrées', data: data1, backgroundColor: 'rgba(59, 130, 246, 0.7)' },
                        { label: 'Sorties', data: data2, backgroundColor: 'rgba(239, 68, 68, 0.7)' }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Statistiques des entrées et sorties' }
                    }
                }
            });
        }

        renderChart(moisLabels, entreeData, sortieData);

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
