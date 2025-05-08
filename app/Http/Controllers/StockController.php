<?php
namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Produit;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $totalProduits = Produit::count();
        $stockFaible = Produit::where('quantite', '>', 0)->where('quantite', '<', 10)->count();
        $stockEpuise = Produit::where('quantite', '=', 0)->count();
        $produits = Produit::all();
        return view('stock.index', compact( 'totalProduits', 'stockFaible', 'stockEpuise','produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|numeric',
            'lieu_stockage' => 'required|string',
        ]);

        $stock = Stock::create($request->all());
        return response()->json($stock, 201);
    }


    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantite' => 'nullable|numeric',
            'lieu_stockage' => 'nullable|string',
        ]);

        $stock->update($request->all());
        return response()->json($stock);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(null, 204);
    }
}