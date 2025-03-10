<?php

namespace App\Modules\Statistic\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticResource extends JsonResource
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
            'date' => $this->date,
            'taux_prescription' => $this->taux_prescription,
            'taux_service_ordonnance' => $this->taux_service_ordonnance,
            'taux_service_medicament' => $this->taux_service_medicament,
            'taux_occupation' => $this->taux_occupation,
            'taux_peremption' => $this->taux_peremption,
            'taux_proche_perime' => $this->taux_proche_perime,
            'taux_rupture' => $this->uutaux_ruptureid,
            'taux_proche_penuerie' => $this->taux_proche_penuerie,
            'taux_disponibilite_a' => $this->taux_disponibilite_a,
            'taux_disponibilite_b' => $this->taux_disponibilite_b,
            'taux_disponibilite_c' => $this->taux_disponibilite_c,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}