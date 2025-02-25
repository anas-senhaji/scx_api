<?php

namespace App\Modules\Game\Http\Resources;
use App\Modules\Player\Models\Player;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Team\Http\Resources\TeamResource;
use App\Modules\Player\Http\Resources\PlayerResource;

class GameResource extends JsonResource
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
            'game_number' => $this->game_number,
            'home_previous_game_id' => $this->home_previous_game_id,
            'visiting_previous_game_id' => $this->visiting_previous_game_id,
            'round' => $this->round,
            'race_to' => $this->race_to,
            'home_score' => $this->home_score,
            'visiting_score' => $this->visiting_score,
            'game_date' => $this->game_date ? $this->game_date->format('Y-m-d H:i:s') : null,
            'home' => $this->home_type === Player::class 
                    ? new PlayerResource($this->whenLoaded('home')) 
                    : new TeamResource($this->whenLoaded('home')),
            'visiting' => $this->visiting_type === Player::class 
                    ? new PlayerResource($this->whenLoaded('visiting')) 
                    : new TeamResource($this->whenLoaded('visiting')),
            'winner' => !empty($this->winner) && get_class($this->winner) === Player::class 
                    ? new PlayerResource($this->winner) 
                    : new TeamResource($this->winner),
            'losing' => !empty($this->losing) && get_class($this->winner) === Player::class
                    ? new PlayerResource($this->losing) 
                    : new TeamResource($this->losing),
            'is_finished' => $this->is_finished,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}