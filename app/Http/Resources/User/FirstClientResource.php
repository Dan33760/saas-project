<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class FirstClientResource extends JsonResource
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
            'firstName' => $this->fname,
            'lastName' => $this->lname,
            'email' => $this->email,
            'tel' => $this->tel,
            'adresse' => $this->adresse,
            'codePostal' => $this->code_postal,
            'status' => $this->status,
            'ville' => new FirstVilleResource($this->ville),
        ];
    }
}
