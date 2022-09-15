<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Ville\FirstVilleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FirstUserResource extends JsonResource
{

    public function toArray($request)
    {
        // Model Retourné pour le profil User
        return [
            'id' => $this->id,
            'firstName' => $this->fname,
            'lastName' => $this->lname,
            'email' => $this->email,
            'isAdmin' => $this->when($request->user()->isAdmin, true),
            'isTenant' => $this->when($request->user()->isTenant, true),
            'tel' => $this->tel,
            'adresse' => $this->adresse,
            'codePostal' => $this->code_postal,
            'anniversaire' => $this->anniversaire,
            'genre' => $this->genre,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'ville' => new FirstVilleResource($this->ville),
        ];
    }
}
