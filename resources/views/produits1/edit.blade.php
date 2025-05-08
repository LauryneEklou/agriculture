<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Produit - Post-Récolte</title>
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
                <li><a href="{{route('stocks.index')}}">Stocks</a></li>
                <li><a href="{{route('transactions.index')}}" class="active">Transactions</a></li>
                 
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Modifier le Produit : {{ $produit->nom ?? 'Produit non trouvé' }}</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>

            <div class="content-section">
                <form action="{{ route('produits.update', $produit->id) }}" method="POST" class="form-container">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="nom" value="{{ $produit->nom }}" required>
                    </div>

                    <div class="form-group">
                        <label>Type :</label>
                        <select name="type">
                            <option value="Fruits" {{ $produit->type == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                            <option value="Légumes" {{ $produit->type == 'Légumes' ? 'selected' : '' }}>Légumes</option>
                            <option value="Céréales" {{ $produit->type == 'Céréales' ? 'selected' : '' }}>Céréales</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantité en Stock :</label>
                        <input type="number" step="1" name="quantite" value="{{ $produit->quantite }}" required>
                    </div>
                    <div class="form-group">
                        <label>prix unitaire:</label>
                        <input type="number" step="1" name="prix_unitaire" value="{{ $produit->prix_unitaire }}" required>
                    </div>

                    <div class="form-group">
                        <label>Lieu de stockage :</label>
                        <input type="text" name="lieu_stockage" value="{{ $produit->lieu_stockage }}" required>
                    </div>

                    <div class="form-group">
                        <label>Date de Récolte :</label>
                        <input type="date" name="date_recolte" value="{{ $produit->date_recolte }}" required>
                    </div>

                    <div class="form-group">
                        <label>Statut :</label>
                        <select name="statut">
                            <option value="Stocké" {{ $produit->statut == 'Stocké' ? 'selected' : '' }}>Stocké</option>
                            <option value="Vendu" {{ $produit->statut == 'Vendu' ? 'selected' : '' }}>Vendu</option>
                            <option value="Distribué" {{ $produit->statut == 'Distribué' ? 'selected' : '' }}>Distribué</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Mettre à jour</button>
                        <a href="{{ route('produits.index') }}" class="cancel-btn">Annuler</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector('.form-container').classList.remove('hidden');
    });
</script>

</html>
