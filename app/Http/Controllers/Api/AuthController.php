<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Image;
use App\Models\Store;
use App\Models\StoreUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    use Notifiable;

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

        #3. Enregistrement User
        $user = User::create([
            'user_ref' => generate_user_code(),
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        #5. Ajouter la photo du profil par defaut
        $image = new Image(['url_image' => 'profil/icon.png']);
        $user->image()->save($image);

        #6. Ajouter Un Client
        if($request->ref) {
            $store = Store::where('ref_store', $request->ref)->first();
            $client = StoreUser::create([
                'user_id' => $user->id,
                'store_id' => $store->id
            ]);
        }

        #7. Envoi le mail de verification
        event(new Registered($user));

        return response([
            'status' => false,
            'message' => 'Compte creer',
            'token' => $user->createToken('User Token')->plainTextToken
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

    // Verify Email
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
     
        return response([
            'status' => true,
            'message' => 'Email Verifié'
        ]);
    }

    // Renvoi du mail de verification
    public function resendEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        
        return back()->with('message', 'Verification link sent!');
    }
}
