<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Panier;
use App\Models\StoreUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Panier\FirstPanierResource;
use App\Http\Resources\Client\SecondClientResource;
use App\Http\Resources\Store\SecondStoreCollection;
use App\Http\Resources\Panier\FirstPanierCollection;
use App\Http\Resources\Client\SecondClientCollection;

class ClientController extends Controller
{
    // Recuperer Tous les Stores
    public function getStores()
    {
        return new SecondStoreCollection(Store::where('status', true)->get());
    }

    // Recuperer les Stores du client
    public function getStoresClient(Request $request)
    {
        return new SecondClientResource(User::find($request->user()->id));
    }

    // Recuperer Les Shopping Cart Du client
    public function getShoppingCarts(Request $request)
    {
        return new FirstPanierCollection(Panier::where('user_id', $request->user()->id)->get());
    }

    // Recuperer Les Shopping Cart Du client
    public function getShoppingCart(Request $request, $idShopCart)
    {
        $where = [
            'id' => $idShopCart,
            'user_id' => $request->user()->id
        ];

        $shopCart = Panier::where($where)->first();

        if(!$shopCart) {
            return response()->json([
                'status' => false,
                'message' => 'Panier introuvable'
            ], 404);
        }

        return new FirstPanierResource($shopCart);
    }

    // Ajouter un client a un store
    public function addClient(Request $request)
    {
        #1. Trouver le store
        $store = Store::where('ref_store', $request->ref)->first();

        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non trouvé',
            ], 404);
        }

        $where = [
            'user_id' => $request->user()->id, 'store_id' => $store->id
        ];

        #2. Verifier si le client existe
        $storeUser = StoreUser::where($where)->first();

        if($storeUser) {
            return response()->json([
                'status' => false,
                'message' => 'Vous etes deja Client'
            ], 400);
        }

        #3. Ajouter le client
        $client = StoreUser::create([
            'user_id' => $request->user()->id,
            'store_id' => $store->id
        ]);

        // Envoi d'un mail de notification au Store

        return response(['status' => true,'message' => 'Client Ajouté']);
    }
}
