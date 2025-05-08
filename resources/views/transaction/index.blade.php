<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Transactions - Post-Récolte</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <div class="logo">
                <h2>Post-Récolte</h2>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li><a href="{{ route('produits.index') }}">Produits</a></li>
                <li><a href="{{ route('stocks.index') }}">Stocks</a></li>
                <li><a href="{{ route('transactions.index') }}" class="active">Transactions</a></li>
                <li><a href="{{route('statistiques.index')}}" >Statistiques</a></li>                     
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Gestion des Transactions</h1>
                <div class="user-info">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">Déconnexion</button>
                    </form>
                </div>
            </header>

            @if (session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="content-section">
                <div class="section-header">
                    <h2>Nouvelle transaction</h2>
                    <button class="add-btn" onclick="toggleTransactionForm()">+ Nouvelle Transaction</button>
                </div>

                <form method="POST" action="{{ route('transactions.store') }}" id="transactionForm"
                    class="form-container" style="display: none;">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="type">Type de transaction</label>
                            <select id="type" name="type" required onchange="togglePriceField()">
                                <option value="">Sélectionner un type</option>
                                <option value="vente">Vente</option>
                                <option value="distribution">Distribution</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="produit_id">Produit</label>
                            <select id="produit_id" name="produit_id" required>
                                <option value="">Sélectionner un produit</option>
                                @foreach (App\Models\Produit::all() as $produit)
                                    <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantite">Quantité</label>
                            <input type="number" id="quantite" name="quantite" step="1" required>
                        </div>
                        <div class="form-group">
                            <label for="harvestDate">date de la transaction </label>
                            <input type="date" name="date_recolte" required>
                        </div>
                        <div class="form-group">
                            <label for="client">Client/Bénéficiaire</label>
                            <input type="text" id="client" name="client">
                        </div>
                        <div class="form-group" id="priceField">
                            <label for="prix_unitaire">Prix unitaire</label>
                            <input type="number" id="prix_unitaire" name="prix_unitaire" step="0.01">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Enregistrer</button>
                        <button type="button" class="cancel-btn" onclick="toggleTransactionForm()">Annuler</button>
                    </div>
                </form>
            </div>

            <div class="content-section">
                <h2>Historique des transactions</h2>

                <form method="GET" action="{{ route('transactions.index') }}" class="table-filters">
                    <div class="filter-group">
                        <label for="type">Type</label>
                        <select id="type" name="type">
                            <option value="">Tous</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                    {{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="date_start">Date de début</label>
                        <input type="date" id="date_start" name="date_start" value="{{ request('date_start') }}">
                    </div>
                    <div class="filter-group">
                        <label for="date_end">Date de fin</label>
                        <input type="date" id="date_end" name="date_end" value="{{ request('date_end') }}">
                    </div>

                    <button type="submit" class="filter-btn">Filtrer</button>
                    <a href="{{ route('transactions.index') }}" class="reset-btn">Réinitialiser</a>
                    <a href="{{ route('transactions.exportPDF') }}?type={{ request('type') }}&date={{ request('date') }}"
                        class="export-btn">Exporter PDF</a>
                </form>

                <div class="table-container">
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $transaction->type == 'Vente' ? 'sale' : 'distribution' }}">
                                            {{ $transaction->type }}
                                        </span>
                                    </td>
                                    <td>{{ $transaction->produits->nom ?? 'N/A' }}</td>
                                    <td>{{ $transaction->quantite }} {{ $transaction->produits->unite ?? 'unité' }}
                                    </td>
                                    <td>{{ $transaction->client ?? '-' }}</td>
                                    <td>{{ $transaction->produits->prix_unitaire ? number_format($transaction->produits->prix_unitaire, 2) . ' fcfa' : '-' }}
                                    </td>
                                    <td>
                                        @if ($transaction->produits->prix_unitaire)
                                            {{ number_format($transaction->produits->prix_unitaire * $transaction->quantite, 2) }}
                                            fcfa
                                        @else
                                        @endif
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('transactions.destroy', $transaction) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette transaction?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete">Supprimer</button>
                                        </form>
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
            </div>

            <!-- Modal de modification -->
            <div id="editModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close" onclick="closeEditModal()">&times;</span>
                    <h2>Modifier la transaction</h2>
                    <form id="editForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="edit_type">Type de transaction</label>
                                <select id="edit_type" name="type" required onchange="toggleEditPriceField()">
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_produit_id">Produit</label>
                                <select id="edit_produit_id" name="produit_id" required>
                                    @foreach (App\Models\Produit::all() as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_quantite">Quantité</label>
                                <input type="number" id="edit_quantite" name="quantite" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_date">Date</label>
                                <input type="date" id="edit_date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_client">Client/Bénéficiaire</label>
                                <input type="text" id="edit_client" name="client">
                            </div>
                            <div class="form-group" id="edit_priceField">
                                <label for="edit_prix_unitaire">Prix unitaire</label>
                                <input type="number" id="edit_prix_unitaire" name="prix_unitaire" step="0.01">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-btn">Mettre à jour</button>
                            <button type="button" class="cancel-btn" onclick="closeEditModal()">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 700px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Button styles */
        .export-btn,
        .reset-btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 4px;
            margin-left: 10px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        .export-btn {
            background-color: #28a745;
            color: white;
        }

        .reset-btn {
            background-color: #6c757d;
            color: white;
        }
    </style>

    <script>
        // Toggle new transaction form
        function toggleTransactionForm() {
            const form = document.getElementById('transactionForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
            togglePriceField();
        }

        // Toggle price field based on transaction type
        function togglePriceField() {
            const transactionType = document.getElementById('type').value;
            const priceField = document.getElementById('priceField');
            const priceInput = document.getElementById('prix_unitaire');

            if (transactionType === 'Vente') {
                priceField.style.display = 'block';
                priceInput.required = true;
            } else {
                priceField.style.display = 'none';
                priceInput.required = false;
                priceInput.value = '';
            }
        }

        // Toggle edit form price field
        function toggleEditPriceField() {
            const transactionType = document.getElementById('edit_type').value;
            const priceField = document.getElementById('edit_priceField');
            const priceInput = document.getElementById('edit_prix_unitaire');

            if (transactionType === 'Vente') {
                priceField.style.display = 'block';
                priceInput.required = true;
            } else {
                priceField.style.display = 'none';
                priceInput.required = false;
                priceInput.value = '';
            }
        }

        // Open edit modal and populate with transaction data
        function editTransaction(id) {
            // Fetch transaction data with AJAX
            fetch(`/transactions/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('editForm').action = `/transactions/${id}`;
                    document.getElementById('edit_type').value = data.type;
                    document.getElementById('edit_produit_id').value = data.produit_id;
                    document.getElementById('edit_quantite').value = data.quantite;
                    document.getElementById('edit_date').value = data.date;
                    document.getElementById('edit_client').value = data.client || '';
                    document.getElementById('edit_prix_unitaire').value = data.prix_unitaire || '';

                    toggleEditPriceField();
                    document.getElementById('editModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching transaction:', error);
                    alert('Erreur lors de la récupération des données de la transaction');
                });
        }

        // Close edit modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Initialize price field visibility on page load
        document.addEventListener('DOMContentLoaded', function() {
            togglePriceField();
        });
    </script>
</body>

</html>
