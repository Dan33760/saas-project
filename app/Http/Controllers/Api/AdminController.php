<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\FirstUserResource;
use App\Http\Resources\User\FirstUserCollection;
use App\Http\Resources\Store\SingleStoreResource;
use App\Http\Resources\Store\FirstStoreCollection;

class AdminController extends Controller
{
    // Recuperer Tous les Users
    public function getUsers()
    {
        return new FirstUserCollection(User::all());
    }

    // Recouperer un User
    public function getUser($idUser)
    {
        $user = User::find($idUser);
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User Non Trouvé'
            ], 404);
        }

        return new FirstUserResource($user);
    }

    // Recuperer Tous les Stores
    public function getStores()
    {
        return new FirstStoreCollection(Store::all());
    }

    // Recuperer Un Store
    public function getStore($idStore)
    {
        return new SingleStoreResource(Store::find($idStore));
    }
}
