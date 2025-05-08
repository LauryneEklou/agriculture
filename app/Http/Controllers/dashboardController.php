<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function dashboard(){
        $today= Carbon::today();
        $venteDuJour= Transaction::whereDate('created_at',$today)->count();
        $transactions = Transaction::all();
        $vente = Transaction::where('type','vente')->count();
        $nb_produits = Produit::all()->count();
        $distributions = Transaction::where('type', 'distribution')->count();
        return view('dashboard', compact('transactions','vente','nb_produits','today','distributions'));
    }
}
