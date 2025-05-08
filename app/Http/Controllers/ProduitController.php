<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('produits1.index', compact('produits'));
    }

    public function create()
    {
        return view('produits1.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'type' => 'required|string',
            'quantite' => 'required|numeric',
            'prix_unitaire' => 'required|numeric',
            'lieu_stockage' => 'required|string',
            'date_recolte' => 'required|date',
            'statut' => 'required|in:Stocké,Vendu,Distribué',
        ]);

        Produit::create($request->all());

        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Produit $produit)
    {
        return view('produits1.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit)
    {
        $request->validate([
            'nom' => 'required|string',
            'type' => 'required|string',
            'quantite' => 'required|numeric',
            'prix_unitaire' => 'required|numeric',
            'lieu_stockage' => 'required|string',
            'date_recolte' => 'required|date',
            'statut' => 'required|in:Stocké,Vendu,Distribué',
        ]);

        $produit->update($request->all());

        return redirect()->route('produits.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Produit $produit)
    {
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }
}
