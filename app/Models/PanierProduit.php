<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PanierProduit extends Pivot
{
    use HasFactory;

    // protected $table = 'panier_produits';
    protected $fillable = [
        'panier_id',
        'produit_id',
        'qu_produit_pa',
        'prix_total',
    ];
}
