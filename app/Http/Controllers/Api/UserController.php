<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\User\FirstUserResource;

class UserController extends Controller
{
    # Voir le profil user
    public function profilUser(Request $request)
    {
        return new FirstUserResource(User::find($request->user()->id));
    }

    # Modifier le profil User
    public function updateUser(Request $request)
    {
        #1. Validation
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'ville' => 'required',
            'telephone' => 'required|min:6|max:20|unique:users,tel',
            'adresse' => 'required|min:5',
            'code_postal' => 'required',
            'anniversaire' => 'required',
            'genre' => ['required', Rule::in(['Homme', 'Femme'])],
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur de validation',
                'error' => $validation->errors()
            ], 400);
        }

        #3. Modifier les Infos de l'utilisateur 
        $user = User::find($request->user()->id);
        $user->fname = $request->first_name;
        $user->lname = $request->last_name;
        $user->email = $request->email;
        $user->ville_id = $request->ville;
        $user->tel = $request->telephone;
        $user->adresse = $request->adresse;
        $user->code_postal = $request->code_postal;
        $user->anniversaire = $request->anniversaire;
        $user->genre = $request->genre;
        $user->save();

        return response([
            'status' => true,
            'message' => 'Profil Utilisateur Modifié'
        ]);
    }

    # Modifier Photo Profil
    public function updateProfilImage(Request $request)
    {
        #1. Validation de l'image
        $validation = Validator::make($request->all(), [
            'file' => ['required','image:png,jpeg,jpg', 'max:2048']
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Changer la Photo de Profil
        $image = [];
        $fileName = time(). '.' .$request->file->extension();
        $path = $request->file('file')->storeAs('profil', $fileName, 'public');
        // $image = new Image(['url_image' => $path]);

        $user = User::find($request->user()->id);
        $user->image()->update(['url_image' => $path]);

        return response([
            'status' => true,
            'message' => 'Photo de profil changée',
            'file' => $fileName
        ]);
        
    }

    # Ajouter Un client
    public function addClient(Request $request)
    {


        return response()->json([
            'code' => $this->generateStoreCode('Fongolab')
        ], 200);
    }


    //-- Generer le code Store
    public function generateStoreCode($societe)
    {
        $index = Str::remove('.',Str::limit($societe, 2));
        $aleatCode = Str::random(4);
        $code = $index.(time() - 1662710000).''.$aleatCode;

        return $code;
    }
}
