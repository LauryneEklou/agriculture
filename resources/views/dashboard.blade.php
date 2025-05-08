<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion Post-Récolte</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Post-Récolte</h2>
            </div>
            <ul class="nav-links">
                <li><a href="{{route('dashboard')}}" class="active">Tableau de bord</a></li>
                <li><a href="{{route('produits.index')}}">Produits</a></li>
                <li><a href="{{route('stocks.index')}}">Stocks</a></li>
                 <li><a href="{{route('transactions.index')}}" >Transactions</a></li>
                <li><a href="{{route('statistiques.index')}}" >Statistiques</a></li>                     

            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Tableau de bord</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                    @csrf
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>
                        @if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px;">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif
            <div class="dashboard-grid">
                <div class="card">
                    <h3>Produits en Stock</h3>
                    <p class="number">{{$nb_produits}}</p>
                </div>
                <div class="card">
                    <h3>Total des ventes  </h3>
                    <p class="number">{{$vente}}</p>
                </div>
                <div class="card">
                    <h3>Distributions</h3>
                    <p class="number">{{$distributions}}</p>
                </div>
            </div>

            <div class="table-container">
                <h2>Activite recente</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Client/Bénéficiaire</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y')}}</td>
                            <td>
                                <span class="badge {{ $transaction->type == 'Vente' ? 'sale' : 'distribution' }}">
                                    {{ $transaction->type }}
                                </span>
                            </td>
                            <td>{{ $transaction->produits->nom ?? 'N/A' }}</td>
                            <td>{{ $transaction->quantite }} {{ $transaction->produits->unite ?? 'unité' }}</td>
                            <td>{{ $transaction->client ?? '-' }}</td>
                            <td>{{ $transaction->produits->prix_unitaire ? number_format($transaction->produits->prix_unitaire, 2) . ' fcfa' : '-' }}</td>
                            <td>
                                @if($transaction->produits->prix_unitaire)
                                    {{ number_format($transaction->produits->prix_unitaire * $transaction->quantite, 2) }} fcfa
                                @else
                                    
                                @endif
                            </td>
                
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucune transaction trouvée</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html> 