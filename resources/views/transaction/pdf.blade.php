<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transactions PDF</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        body {
            font-size: 12pt;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        
        /* Header section */
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            width: 200px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
        }
        
        .logo-placeholder {
            font-weight: bold;
            color: #666;
        }
        
        .company-info {
            text-align: right;
        }
        
        h1 {
            font-size: 24pt;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .report-meta {
            margin-bottom: 20px;
            text-align: right;
            font-size: 10pt;
            color: #666;
        }
        
        /* Table styles */
        .table-container {
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
            font-size: 11pt;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        
        /* Badge styles */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 80px;
        }
        
        .sale {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        
        .distribution {
            background-color: #d9edf7;
            color: #31708f;
            border: 1px solid #bce8f1;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 9pt;
            color: #777;
            text-align: center;
        }
        
        .page-number {
            font-style: italic;
        }
        
        /* Empty state */
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <div class="logo-placeholder">LOGO</div>
        </div>
        <div class="company-info">
            <h3>Nom de l'entreprise</h3>
            <p>123 Rue Exemple, Ville</p>
            <p>Téléphone: +000 000 000 00</p>
            <p>Email: contact@exemple.com</p>
        </div>
    </div>
    
    <h1>Liste des transactions</h1>
    
    <div class="report-meta">
        <p>Date d'édition: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p>Nombre de transactions: {{ count($transactions) }}</p>
    </div>
    
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
    
    <div class="footer">
        <p>Ce document est généré automatiquement et ne nécessite pas de signature.</p>
        <p class="page-number">Page 1</p>
    </div>
</body>
</html>