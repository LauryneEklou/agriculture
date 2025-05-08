<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'type', 'quantite','prix_unitaire','lieu_stockage' ,'date_recolte', 'statut'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'produit_id', 'id');
    }
}
