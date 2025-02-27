<?php

namespace App\Modules\ULC\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\UMMC\Http\Resources\UMMCCollection;
use App\Modules\Statistic\Http\Resources\StatisticCollection;

class ULCResource extends JsonResource
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
            'position_x' => $this->position_x,
            'position_y' => $this->position_y,
            'position' => $this->position_x.', '.$this->position_y,
            'ummcs' => new UMMCCollection($this->whenLoaded('ummcs')),
            'statistics' => new StatisticCollection($this->whenLoaded('statistics')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}