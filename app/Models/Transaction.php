<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite',
        'prix_total',
        'client',
        'type',
    ];

    public function produits()
    {
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }
}
