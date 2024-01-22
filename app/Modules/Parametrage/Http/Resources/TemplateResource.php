<?php

namespace App\Modules\Parametrage\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Parametrage\Http\Resources\TemplateVariableCollection;

class TemplateResource extends JsonResource
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
            'uuid' => $this->uuid,
            'nom' => $this->nom,
            'type' => $this->type,
            'path' => $this->path,
            'variables' => new TemplateVariableCollection($this->whenLoaded('variables')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
