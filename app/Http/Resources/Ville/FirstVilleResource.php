<?php

namespace App\Http\Resources\Ville;

use App\Http\Resources\Pays\FirstPaysResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FirstVilleResource extends JsonResource
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
            'nom' => $this->nom_ville,
            'pays' => new FirstPaysResource($this->pays)
        ];
    }
}
