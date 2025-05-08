<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Statistique</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Post-Récolte</h2>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li><a href="{{ route('produits.index') }}">Produits</a></li>
                <li><a href="{{ route('stocks.index') }}">Stocks</a></li>
                <li><a href="{{ route('transactions.index') }}" >Transactions</a></li>
                <li><a href="{{route('statistiques.index')}}" class="active" >Statistiques</a></li>                     
            </ul>
        </nav>
        @if (session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif
        <main class="main-content">
            <header>
                <h1 class="text-3xl font-bold mb-4">Tableau de Bord des Statistiques</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>
            <p class="text-gray-600 mb-8">Aperçu de la performance et des activités</p>

            <!-- Cartes Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-indigo-500 text-3xl mb-2">📦</div>
                    <h2 class="text-gray-700 font-bold">Total Produits</h2>
                    <p class="text-2xl">{{ $totalProduits }}</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-purple-500 text-3xl mb-2">📦</div>
                    <h2 class="text-gray-700 font-bold">Stock Total</h2>
                    <p class="text-2xl">{{ $totalStock }}</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-blue-500 text-3xl mb-2">🛒</div>
                    <h2 class="text-gray-700 font-bold">Total Ventes</h2>
                    <p class="text-2xl">{{ $totalVentes }}</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-green-500 text-3xl mb-2">🔄</div>
                    <h2 class="text-gray-700 font-bold">Total Distributions</h2>
                    <p class="text-2xl">{{ $totalDistributions }}</p>
                </div>
                <div class="bg-white p-6 rounded shadow text-center">
                    <div class="text-yellow-500 text-3xl mb-2">💰</div>
                    <h2 class="text-gray-700 font-bold">Revenu Total</h2>
                    <p class="text-2xl">{{ number_format($revenuTotal, 2) }} FCFA</p>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">Évolution Mensuelle</h2>
                    <canvas id="evolutionChart"></canvas>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">Produits Populaires</h2>
                    <canvas id="produitsChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-bold mb-4">Répartition des Revenus</h2>
                    <canvas id="revenuChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Script Chart.js -->
    <script>
        // Evolution Mensuelle
        new Chart(document.getElementById('evolutionChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($mois) !!},
                datasets: [{
                        label: 'Ventes',
                        data: {!! json_encode($ventesParMois) !!},
                        borderColor: 'blue',
                        backgroundColor: 'blue',
                        tension: 0.4,
                        fill: false,
                    },
                    {
                        label: 'Distributions',
                        data: {!! json_encode($distributionsParMois) !!},
                        borderColor: 'lightblue',
                        backgroundColor: 'lightblue',
                        tension: 0.4,
                        fill: false,
                    }
                ]
            },
        });

        // Produits Populaires
        new Chart(document.getElementById('produitsChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($produitsPopulairesLabels) !!},
                datasets: [{
                    label: 'le plus  vendue',
                    data: {!! json_encode($produitsPopulairesData) !!},
                    backgroundColor: ['#ef4444', '#10b981', '#8b5cf6', '#f59e0b', '#3b82f6']
                }]
            },
        });

        // Répartition du Stock
        new Chart(document.getElementById('stockChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($stockLabels) !!},
                datasets: [{
                    data: {!! json_encode($stockData) !!},
                    backgroundColor: ['#f43f5e', '#22c55e', '#3b82f6', '#eab308', '#a855f7']
                }]
            },
        });

        // Répartition des Revenus
        new Chart(document.getElementById('revenuChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenuLabels) !!},
                datasets: [{
                    data: {!! json_encode($revenuData) !!},
                    backgroundColor: ['#f87171', '#34d399', '#60a5fa', '#facc15']
                }]
            },
        });
    </script>

</body>

</html>
