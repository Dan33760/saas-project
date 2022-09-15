<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    # Enregistrer un User
    public function registerUser(Request $request)
    {
        #1. Validation des donnees
        $validation = Validator::make($request->all(), [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255'
        ]);
        
        #2. Erreur de validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Enregistrement de l'Utilisateur
        $user = User::create([
            'user_ref' => $this->generateUserCode(),
            'fname' => $request->first_name,
            'lname' => $request->last_namem,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $image = new Image(['url_image' => 'profil/icon.png']);
        $user->image()->save($image);

        return response([
            'status' => false,
            'message' => 'Compte creer'
        ]);
    }

    # Login
    public function loginUser(Request $request)
    {
        #1. Validation des donnees
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        #2. Erreur de validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ], 400);
        }

        #3. Verifier le mail et le mot de passe
        if(!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'L\'adresse mail ou le mot de passe est incorect'
            ], 400);
        }

        #4. Retourne l'utilisateur et son Token
        $user = User::where('email', $request->email)->first();

        return response([
            'status' => true,
            'message' => 'Utilisateur Connecté',
            'token' => $user->createToken('User Token')->plainTextToken
        ]);
    }

    # Genereer Un Code User
    public function generateUserCode()
    {
        $codeAleatoire = Str::upper(Str::random(4));
        $code = 'FY'.(time() - 1662710000).''.$codeAleatoire;

        return $code;
    }
}
