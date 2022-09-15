<?php

namespace App\Http\Resources\Pays;

use Illuminate\Http\Resources\Json\JsonResource;

class FirstPaysResource extends JsonResource
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
            'code' => $this->alpha2,
            'nom_en' => $this->nom_en_gb,
            'nom_fr' => $this->nom_fr_fr,
        ];
    }
}
