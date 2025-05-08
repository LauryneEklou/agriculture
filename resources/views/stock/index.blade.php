<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Stocks - Post-Récolte</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Post-Récolte</h2>
            </div>
            <ul class="nav-links">
                <li><a href="{{route('dashboard')}}">Tableau de bord</a></li>
                <li><a href="{{route('produits.index')}}">Produits</a></li>
                <li><a href="{{route('stocks.index')}}" class="active">Stocks</a></li>
                 <li><a href="{{route('transactions.index')}}" >Transactions</a></li>
                <li><a href="{{route('statistiques.index')}}" >Statistiques</a></li>                     
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Gestion des Stocks</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                    @csrf
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>

            <div class="content-section">
                <h2>État des stocks</h2>
                <div class="stock-summary">
                    <div class="stock-card">
                        <h3>Total des produits</h3>
                        <p class="number">{{ $totalProduits }}</p>
                    </div>
                    <div class="stock-card">
                        <h3>Stock faible</h3>
                        <p class="number warning">{{ $stockFaible }}</p>
                    </div>
                    <div class="stock-card">
                        <h3>Stock épuisé</h3>
                        <p class="number danger">{{ $stockEpuise }}</p>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h2>Liste des stocks</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Type</th>
                                <th>Quantité en stock</th>
                                <th>Lieu de stockage</th>
                                <th>Statuts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ $produit->type }}</td>
                                    <td>{{ $produit->quantite }}</td>
                                    <td>{{ $produit->lieu_stockage }}</td>
                                    <td>
                                        @if ($produit->quantite > 10)
                                            <span class="badge bg-success">Disponible</span>
                                        @elseif($produit->quantite > 0)
                                            <span class="badge bg-warning">Faible stock</span>
                                        @else
                                            <span class="badge bg-danger">Rupture</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

          
        </main>
    </div>

    <script>
        function toggleStockForm() {
            const form = document.getElementById('stockForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
