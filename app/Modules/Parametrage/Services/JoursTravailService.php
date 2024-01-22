<?php

namespace App\Modules\Parametrage\Services;

use App\Traits\CustomResponse;
use App\Modules\Parametrage\Models\JoursTravail;

class JoursTravailService
{
    use CustomResponse;

    public function switch($jourTravail){
        $jourTravail->est_travailleur = !$jourTravail->est_travailleur;
        $jourTravail->save();
        $jourTravail = $jourTravail->fresh();
        return $this->jsonResponse(true, 200, 200, $jourTravail);
    }

    public function getAll($paginate = false, $perPage = 10){
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, JoursTravail::paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, JoursTravail::all());
    }
}