<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produit;
use App\Models\PanierProduit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panier extends Model
{
    use HasFactory;

    //-- Relation One To Many (Plusieurs Panier Pour un User)
    public function client()
    {
        return $this->belongsTo(User::class);
    }

    //-- Relation One To Many (Un Panier possede Plusieurs Produits)
    public function produits()
    {
        return $this->belongsToMany(Produit::class)
                    ->using(PanierProduit::class)
                    ->withPivot('qu_produit_pa', 'prix_total');
    }
}
