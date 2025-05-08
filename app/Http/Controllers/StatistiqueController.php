<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Liste des mois pour les graphiques
        $mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        // Statistiques globales
        $totalProduits = Produit::count();
        $totalStock = Produit::sum('quantite');
        $totalVentes = Transaction::where('type', 'Vente')->sum('quantite');
        $totalDistributions = Transaction::where('type', 'Distribution')->sum('quantite');
        $revenuTotal = Transaction::where('transactions.type', 'Vente')
            ->join('produits', 'transactions.produit_id', '=', 'produits.id')
            ->selectRaw('SUM(transactions.quantite * produits.prix_unitaire) as total')
            ->first()->total ?? 0;

        // Ventes par mois (12 derniers mois)
        $ventesParMois = $this->getDataParMois('Vente');
        $distributionsParMois = $this->getDataParMois('Distribution');

        // Produits populaires
        $produitsPopulaires = Transaction::where('transactions.type', 'Vente')
            ->join('produits', 'transactions.produit_id', '=', 'produits.id')
            ->select('produits.nom', DB::raw('SUM(transactions.quantite) as total'))
            ->groupBy('produits.nom')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $produitsPopulairesLabels = $produitsPopulaires->pluck('nom');
        $produitsPopulairesData = $produitsPopulaires->pluck('total');

        // Stock actuel
        $stocks = Stock::join('produits', 'stocks.produit_id', '=', 'produits.id')
            ->select('produits.nom', 'stocks.quantite')
            ->where('stocks.quantite', '>', 0)
            ->orderBy('stocks.quantite', 'desc')
            ->limit(5)
            ->get();
        $stockLabels = $stocks->pluck('nom');
        $stockData = $stocks->pluck('quantite');

        // Revenu par catégorie (exemple si produit a une colonne `categorie`)
        $revenus = Transaction::where('transactions.type', 'Vente')
            ->join('produits', 'transactions.produit_id', '=', 'produits.id')
            ->select('produits.nom', DB::raw('SUM(transactions.quantite * produits.prix_unitaire) as revenu'))
            ->groupBy('produits.nom')
            ->get();
        $revenuLabels = $revenus->pluck('categorie');
        $revenuData = $revenus->pluck('revenu');

        return view('statistiques.index', compact(
            'mois', 'ventesParMois', 'distributionsParMois',
            'produitsPopulairesLabels', 'produitsPopulairesData',
            'stockLabels', 'stockData',
            'revenuLabels', 'revenuData',
            'totalProduits', 'totalStock', 'totalVentes',
            'totalDistributions', 'revenuTotal'
        ));
    }

    /**
     * Retourne les données (ventes ou distributions) par mois sous forme de tableau indexé de 12 valeurs.
     */
    protected function getDataParMois($type)
    {
        $result = array_fill(0, 12, 0); // Indexé de Janvier (0) à Décembre (11)

        $data = Transaction::where('type', $type)
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(quantite) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        foreach ($data as $item) {
            $index = $item->mois - 1;
            $result[$index] = (int)$item->total;
        }

        return $result;
    }
}
