<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    # Ajouter Une Boutique
    public function addAtore(Request $request)
    {
        #1. Validation
        $validation = Validator::make($request->all(), [
            'designation' => 'required|min:3|max:50',
            'url_site' => 'required|min:3|max:50',
            'email_notification' => 'required|email|unique:stores,email_notification',
            'email_assistance' => 'required|email|unique:stores,email_assistance'
        ]);
    }
}
