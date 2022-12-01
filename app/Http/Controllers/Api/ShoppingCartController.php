<?php

namespace App\Http\Controllers\Api;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\PanierProduit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ShoppingCartController extends Controller
{
    // Ajouter Un Shopping Cart
    public function addShoppingCart(Request $request)
    {
        #1. Validation des donnees
        $validation = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:20|unique:paniers,nom_panier',
            'produit.*' => 'required|integer|distinct',
            'quantite.*' => 'required|integer'
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Enregistrer le Shopping Cart
        $shopCart = Panier::create([
            'user_id' => $request->user()->id,
            'ref_panier' => new_shop_cart_code(),
            'nom_panier' => $request->designation
        ]);

        #4. Enregistrer les produits du Shopping Cart
        foreach($request->produit as $key => $id)
        {
            $produit = Produit::find($request->produit[$key]);
            $produits[] = [
                'panier_id' => $shopCart->id,
                'produit_id' => $produit->id,
                'qu_produit_pa' => $request->quantite[$key],
                'prix_total' => $request->quantite[$key] * $produit->pu_produit
            ];
        }

        $shopCartProduct = PanierProduit::insert($produits);

        return response([
            'status' => true,
            'message' => 'Panier Ajouté'
        ]);
    }
}
