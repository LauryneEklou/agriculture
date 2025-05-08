<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'produit_id',
        'quantite',
        'lieu_stockage',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
