<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits - Post-Récolte</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Post-Récolte</h2>
            </div>
            <ul class="nav-links">
                <ul class="nav-links">
                    <li><a href="{{route('dashboard')}}">Tableau de bord</a></li>
                    <li><a href="{{route('produits.index')}}" class="active">Produits</a></li>
                    <li><a href="{{route('stocks.index')}}">Stocks</a></li>
                    <li><a href="{{route('transactions.index')}}" >Transactions</a></li>
                    <li><a href="{{route('statistiques.index')}}" >Statistiques</a></li>                     
                </ul>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Gestion des Produits</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                    @csrf
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>

            <div class="content-section">
                <div class="section-header">
                    <h2>Ajouter un nouveau produit</h2>
                    <button class="add-btn" onclick="toggleForm()">+ Nouveau Produit</button>
                </div>

                <form id="productForm" action="{{ route('produits.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nom du produit</label>
                            <input type="text" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label>Type de produit</label>
                            <select name="type">
                                <option value="">selectionner un type</option>
                                <option value="Fruits">Fruits</option>
                                <option value="Légumes">Légumes</option>
                                <option value="Céréales">Céréales</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantité récoltée</label>
                            <input type="number" step="1" name="quantite" required>
                        </div>
                        <div class="form-group">
                            <label>prix unitaire </label>
                             <input type="number" step="1" name="prix_unitaire" required>
                         </div>
                        <div class="form-group">
                            <label for="harvestDate">Date de récolte</label>
                            <input type="date" name="date_recolte" required>
                        </div>
                        <div class="form-group">
                            <label>Lieu de stockage :</label>
                            <input type="text" name="lieu_stockage" required><br>
                        </div>
                        <div class="form-group">
                            <label >Statut</label>
                            <select name="statut" required>
                                <option value="">Sélectionner un statut</option>
                                <option value="Stocké">Stocké</option>
                                <option value="Vendu">Vendu</option>
                                <option value="Distribué">Distribué</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Enregistrer</button>
                        <button type="button" class="cancel-btn" onclick="toggleForm()">Annuler</button>
                    </div>
                </form>
            </div>

            <div class="content-section">
                <h2>Liste des produits</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Date de récolte</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produits as $produit)
                                <tr>
                                    <td>{{ $produit->nom }}</td>
                                    <td>{{ $produit->type }}</td>
                                    <td>{{ $produit->quantite }}</td>
                                    <td>{{ $produit->prix_unitaire }}</td>
                                    <td>{{ $produit->date_recolte }}</td>
                                    <td>{{ $produit->statut }}</td>
                                    <td>
                                        <a href="{{ route('produits.edit', $produit) }}"
                                            class="action-btn success">Modifier</a>

                                        <form action="{{ route('produits.destroy', $produit) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete">Supprimer</button>
                                        </form>
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
        function toggleForm() {
            const form = document.getElementById('productForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>