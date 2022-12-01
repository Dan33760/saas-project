<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\Image\FirstImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SecondStoreResource extends JsonResource
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
            'email_assistance' => $this->email_assistance,
            'created_at' => $this->created_at,
            'produits_count' => $this->produits->count(),
            'image' => new FirstImageResource($this->image)
        ];
    }
}
