<?php

namespace App\Modules\Groupe\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupeResource extends JsonResource
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
            'uuid' => $this->uuid,
            'nom' => $this->nom,
            'logo' => $this->logo,
        ];
    }
}
