<?php

namespace App\Http\Resources\Panier;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Produit\SecondProduitCollection;

class FirstPanierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'designation' => $this->nom_panier,
            'status' => $this->status,
            'produits' => new SecondProduitCollection($this->produits)
        ];
    }
}
