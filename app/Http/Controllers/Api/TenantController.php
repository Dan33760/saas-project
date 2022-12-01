<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Store\SingleStoreResource;
use App\Http\Resources\Store\FirstStoreCollection;
use App\Http\Resources\Produit\FirstProduitResource;

class TenantController extends Controller
{
    // Recuperer Les Stores Du Tenant
    public function getStores(Request $request)
    {
        $stores = Store::where('user_id', $request->user()->id)->get();
        
        // verifier si le store existe
        if(!$stores) {
            return response()->json([
                'status' => false,
                'message' => 'Boutiques non trouvé',
            ], 404);
        }

        return new FirstStoreCollection($stores);
    }

    // Recuperer Un Store est toutes ses infos
    public function getStore(Request $request, $idStore)
    {
        $where = [
            'id' => $idStore,
            'user_id' => $request->user()->id
        ];
        $store = Store::where($where)->with('users')->first();
        
        // verifier si le store existe
        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non trouvé',
            ], 404);
        }
        return new SingleStoreResource($store);
        // return $store;
    }

    // Recuperer un produit
    public function getProduct(Request $request, $idProduct)
    {
        $product = Produit::find($idProduct);

        if(!$product) {
            return rsponse()->json([
                'status' => false,
                'message' => 'Produit non Trouvé'
            ], 404);
        }

        return new FirstProduitResource($product);
    }
}
