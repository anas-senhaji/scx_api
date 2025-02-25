<?php

namespace App\Modules\Tournament\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Event\Http\Resources\EventResource;
use App\Modules\Team\Http\Resources\TeamCollection;
use App\Modules\Player\Http\Resources\PlayerCollection;
use App\Modules\Location\Http\Resources\CountryResource;
use App\Modules\Organizer\Http\Resources\OrganizerResource;
use App\Modules\Discipline\Http\Resources\DisciplineResource;
use App\Modules\Tournament\Http\Resources\TournamentTypeResource;

class TournamentResource extends JsonResource
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
            'start_date' => $this->start_date,
            'place' => $this->place,
            'info' => $this->info,
            'ranking_points' => $this->ranking_points,
            'prize_money' => $this->prize_money,
            'country_id' => $this->country_id,
            'end_date' => $this->end_date,
            'organizer' => new OrganizerResource($this->whenLoaded('organizer')),
            'type' => new TournamentTypeResource($this->whenLoaded('tournamentType')),
            'event' => new EventResource($this->whenLoaded('event')),
            'discipline' => new DisciplineResource($this->whenLoaded('discipline')),
            'players' => new PlayerCollection($this->whenLoaded('players')),
            'teams' => new TeamCollection($this->whenLoaded('teams')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'is_activated' => $this->is_activated,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}