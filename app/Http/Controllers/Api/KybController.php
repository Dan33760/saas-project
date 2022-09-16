<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KybController extends Controller
{
    // Ajouter les fichiers
    public function addKyb(Request $request)
    {
        #1. Validation des donnees
        $validation = Validator::make($request->all(), [
            'store_id' => 'required',
            'description.*' => 'required|min:3|max:20',
            'files.*' => ['required', 'mimes:jpg,jpeg,png,pdf']
        ]);

        #2. Verifier la validation
        if($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors(),
            ], 400);
        }

        #3. Extraire les Donnees
        $kyb = null;
        if($request->hasFile('files'))
        {
            foreach($request->file('files') as $key => $file)
            {
                $fileName = time(). '.' . $file->extension();
                $path = $file->storeAs('KYB', $fileName, 'public');

                $kyb[] = [
                    'store_id' => $request->store_id,
                    'description' => $request->description[$key],
                    'file_name' => $fileName,
                    'file_url' => $path
                ];
            }
        }

        #4. Enregistrer les Donnees
        $documents = Document::insert($kyb);

        return response([
            'status' => true,
            'message' => 'KYC envoyé',
        ]);
    }
}
