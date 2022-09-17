<?php

namespace App\Http\Controllers\Api;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Produit\FirstProduitCollection;

class ProductController extends Controller
{
    // Get Products
    public function getProducts_(Request $request, $idStore)
    {
        return new FirstProduitCollection(Produit::where('store_id', $idStore)->get());
    }

    // Add Product
    public function addProduct(Request $request)
    {
        #1. Verification data
        $validation = Validator::make($request->all(), [
            'store_id' => 'require',
            'nom_produit' => 'required|min:3|max:20|unique:produits,nom_produit',
            'prix_unit' => 'required',
            'quantite' => 'required',
            'seuil' => 'required',
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Enregistrer le produit
        $produit = Produit::create([
            'store_id' => $request->store,
            'nom_produit' => $request->nom_produit,
            'pu_produit' => $request->prix_unit,
            'qu_produit' => $request->quantite,
            'seuil' => $request->seuil
        ]);

        return response([
            'status' => true,
            'message' => 'Produit Ajouté'
        ]);
    }

    // Update Product
    public function updateProduct(Request $request, $idProduit)
    {
        #1. Verification data
        $validation = Validator::make($request->all(), [
            'nom_produit' => 'required|min:3|max:20',
            'prix_unit' => 'required',
            'quantite' => 'required',
            'seuil' => 'required',
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Enregistrer le produit
        $produit = Produit::find($idProduit);
        $produit->nom_produit = $request->nom_produit;
        $produit->pu_produit = $request->prix_unit;
        $produit->qu_produit = $request->quantite;
        $produit->seuil = $request->seuil;
        $produit->save(); 

        return response([
            'status' => true,
            'message' => 'Produit Modifié'
        ]);
    }

    // Delete product
    public function deleteProduct($idProduct)
    {
        $product = Produit::find($idProduct);

        if(!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produit Non Trouvé'
            ], 404);
        }

        $product->delete();

        return response([
            'status' => true,
            'message' => 'Produit Supprimé'
        ]);
    }

    // Active product
    public function activeProduct($idProduct)
    {
        $product = Produit::find($idProduct);

        if(!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Produit Non Trouvé'
            ], 404);
        }

        $product->status = 1;
        $product->save();

        return response([
            'status' => true,
            'message' => 'Produit Activé'
        ]);
    }
}
