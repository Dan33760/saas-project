<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Produit;
use App\Models\PanierProduit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'nom_produit',
        'pu_produit',
        'qu_produit',
        'seuil',
    ];

    //-- Relation One To Many (Plusieurs Produits pour Un Store)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    //-- Relation One To Many (Un produit apparait dans Plusieurs paniers)
    public function produits()
    {
        return $this->belongsToMany(Produit::class)
                    ->using(PanierProduit::class)
                    ->withPivot('qu_produit_pa', 'prix_total');
    }
}
