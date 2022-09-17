<?php

namespace App\Http\Resources\Store;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\FirstClientCollection;
use App\Http\Resources\Produit\FirstProduitCollection;

class SingleStoreResource extends JsonResource
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
            'nom' => $this->name_store,
            'code_reference' => $this->ref_store,
            'url_site' => $this->url_site,
            'url_affiliation' => $this->url_affiliation,
            'email_notification' => $this->email_notification,
            'email_assistance' => $this->email_assistance,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'status_kyb' => $this->isValidKyb,
            'produits_count' => $this->produits->count(),
            'clients_count' => $this->users->count(),
            'produits' => new FirstProduitCollection($this->produits),
            'clients' => new FirstClientCollection($this->whenLoaded('users')),
            'image' => $this->image
        ];
    }
}
