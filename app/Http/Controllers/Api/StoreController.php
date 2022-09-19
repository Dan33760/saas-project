<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    // Ajouter le Store
    public function addStore(Request $request)
    {
        #1. Validation
        $validation = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:50|unique:stores,name_store',
            'url_site' => 'required|min:3|max:50|unique:stores,url_site',
            'email_notification' => 'required|email|unique:stores,email_notification',
            'email_assistance' => 'required|email|unique:stores,email_assistance'
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors(),
            ], 400);
        }

        #3. Enregistrer le Store
        $ref_store = generate_store_code($request->designation);
        $store = Store::create([
            'user_id' => $request->user()->id,
            'name_store' => $request->designation,
            'ref_store' => $ref_store,
            'url_site' => $request->url_site,
            'url_affiliation' => route('user.add', ['ref' => $ref_store]),
            'email_notification' => $request->email_notification,
            'email_assistance' => $request->email_assistance,
        ]);

        #5. Ajouter la photo du profil par defaut
        $image = new Image(['url_image' => 'stores/icon.png']);
        $store->image()->save($image);

        #6. Enregistrer User en tant que tenant
        $user = User::find($request->user()->id);
        if($user->isTenant == "0") {
            $user->isTenant = "1";
            $user->save();
        }
        
        return response([
            'status' => true,
            'message' => 'Boutique Ajoutée',
            'store' => $user
        ]);
    }

    // Modifier un store
    public function updateStore(Request $request, $idStore)
    {
        #1. Validation
        $validation = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:50',
            'url_site' => 'required|min:3|max:50',
            'email_notification' => 'required|email',
            'email_assistance' => 'required|email'
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors(),
            ], 400);
        }

        #3. Modifier le Store
        $store = Store::find($idStore);
        $store->name_store = $request->designation;
        $store->url_site = $request->url_site;
        $store->email_notification = $request->email_notification;
        $store->email_assistance = $request->email_assistance;
        $store->save();

        return response([
            'status' => true,
            'message' => 'Boutique Ajoutée',
            'store' => $store
        ]);
    }

    // Modifier l'icone du profil
    public function changeIcon(Request $request, $idStore)
    {
        #1. Verification Du Fichier
        $validation = Validator::make($request->all(), [
            'image' => ['required', 'image:jpeg,jpg,png']
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Enregistrer le fichier
        $fileName = time(). '.' .$request->file('image')->extension();
        $path = $request->file('image')->storeAs('stores', $fileName, 'public');

        $store = Store::find($idStore);
        $store->image()->update(['url_image' => $path]);

        return response([
            'status' => true,
            'messsage' => 'Icon Changé'
        ]);

    }

    // Supprimer un store
    public function deleteStore($idStore)
    {
        $store = Store::find($idStore);
        
        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non Trouvée'
            ], 404);
        }

        $store->delete();

        return response([
            'status' => true,
            'message' => 'Boutique Supprimée'
        ]);
    }

    //-- Activer un store
    public function activeStore($idStore)
    {
        $store = Store::find($idStore);

        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non Trouvée'
            ], 404);
        }

        $store->status = 1;
        $store->save();

        return response([
            'status' => true,
            'message' => 'Boutique Activée',
        ]);
    }

    //-- Desactiver un store
    public function desactiveStore($idStore)
    {
        $store = Store::find($idStore);

        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non Trouvée'
            ], 404);
        }

        $store->status = 0;
        $store->save();

        return response([
            'status' => true,
            'message' => 'Boutique Desactivée',
        ]);
    }

    // Valider KYB
    public function validateKyb($idStore)
    {
        $store = Store::find($idStore);

        if(!$store) {
            return response()->json([
                'status' => false,
                'message' => 'Boutique non Trouvée'
            ], 404);
        }

        $store->isValidKyb = 1;
        $store->save();

        // Envoi de mail

        return response([
            'status' => true,
            'message' => 'KYB Activée',
        ]);
    }

}
