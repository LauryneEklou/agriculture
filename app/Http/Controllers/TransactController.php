<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Produit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class TransactController extends Controller
{
    // Affiche la page avec la liste et les filtres

    public function index(Request $request)
    {
        $query = Transaction::query();

        // Filtres
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filtrer par intervalle de dates
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('created_at', [$request->date_start, $request->date_end]);
        }
        // Si seulement la date de début est remplie
        elseif ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->date_start);
        }
        // Si seulement la date de fin est remplie
        elseif ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        $transactions = $query->latest()->get();

        return view('transaction.index', [
            'transactions' => $transactions,
            'types' => ['Vente', 'Distribution']
        ]);
    }

    // Stocker une nouvelle transaction
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'type' => 'required',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|numeric|min:1',
            'client' => 'nullable|string',
            'prix_unitaire' => 'nullable|numeric'
        ]);
    
        // Récupération du produit
        $produit = Produit::findOrFail($request->produit_id);
    
        // Vérifier que la quantité demandée est disponible
        if ($produit->quantite < $request->quantite) {
            return redirect()->back()->with('error', 'Stock insuffisant pour ce produit.');
        }
    
        // Calcul du prix total
        $prix_total = ($request->prix_unitaire && $request->quantite) ? $request->prix_unitaire * $request->quantite : 0;
    
        // Création de la transaction
        Transaction::create([
            'type' => $request->type,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'client' => $request->client,
            'prix_unitaire' => $request->prix_unitaire,
            'prix_total' => $prix_total,
        ]);
    
        // Diminution du stock du produit
        $produit->quantite -= $request->quantite;
        $produit->save();
    
        return redirect()->back()->with('success', 'Transaction enregistrée et stock mis à jour');
    }
    

    public function update(Request $request, Transaction $transaction)
    {
        // Validation des champs
        $request->validate([
            'type' => 'required',
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|numeric|min:1',
            'date' => 'required|date',
            'client' => 'nullable|string',
            'prix_unitaire' => 'nullable|numeric'
        ]);

        // Calcul de prix_total uniquement si les données sont valides
        $prix_total = ($request->prix_unitaire && $request->quantite) ? $request->prix_unitaire * $request->quantite : 0;

        // Mise à jour de la transaction
        $transaction->update([
            'type' => $request->type,
            'produit_id' => $request->produit_id,
            'quantite' => $request->quantite,
            'date' => $request->date,
            'client' => $request->client,
            'prix_unitaire' => $request->prix_unitaire,
            'prix_total' => $prix_total,
        ]);

        return redirect()->back()->with('success', 'Transaction modifiée');
    }


    // Supprimer une transaction
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction supprimée');
    }

    // Export PDF
    public function exportPDF(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->latest()->get();

        $pdf = Pdf::loadView('transaction.pdf', compact('transactions'));

        return $pdf->download('transaction.pdf');
    }
}
