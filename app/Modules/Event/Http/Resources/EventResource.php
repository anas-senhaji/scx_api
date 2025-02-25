<?php

namespace App\Modules\Event\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Location\Http\Resources\CountryResource;
use App\Modules\Organizer\Http\Resources\OrganizerResource;
use App\Modules\Discipline\Http\Resources\DisciplineResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'place' => $this->place,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'discipline' => new DisciplineResource($this->whenLoaded('discipline')),
            'organizer' => new OrganizerResource($this->whenLoaded('organizer')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}