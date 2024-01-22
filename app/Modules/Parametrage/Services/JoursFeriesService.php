<?php

namespace App\Modules\Parametrage\Services;

use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Parametrage\Models\JoursFeries;
use Carbon\Carbon;

class JoursFeriesService
{
    use CustomResponse;

    // This function is for (Update & Create)
    public function create($request, $joursFeries = null) {

        try {
            // Begin a database transaction
            DB::beginTransaction();
                // Check if the request has a validator property and if it has failed
                if (isset($request->validator) && $request->validator->fails())
                    return $this->jsonResponse(true, 400, 400, $request->validator->messages());
            
                // Update or Create a new JoursFeries model instance with the validated request data
                // Initialize an empty result array
                $result = [];
                // Loop through each date in the request
                foreach ($request->dates as $date) {
                    // Convert the date string to a Carbon instance
                    $date = Carbon::createFromFormat('Y-m-d', $date);
                    // Create an array of data for the JoursFeries model
                    $data = [
                        'nom' => $request->nom,
                        'jour' => $date->day,
                        'mois' => $date->month,
                        'annee' => (isset($request->fixe) && $request->fixe == false) ? $date->year : null,
                        'fixe' => $request->fixe
                    ];
                    if($joursFeries){
                        $this->delete($joursFeries);
                    }
                    $createdJoursFeries = JoursFeries::create($data);
                    // Add the created/fresh JoursFeries model to the result array
                    $result[] = $createdJoursFeries;
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created/fresh JoursFeries objects
            return $this->jsonResponse(true, 200, 200, $result);

        } catch (\Exception $e) {

            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());

        }
        
    }

    public function delete($joursFeries){
        $joursFeries->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($joursFeries){
        return $this->jsonResponse(true, 200, 200, $joursFeries);
    }

    public function getAll($paginate = false, $perPage = 10){
        // If pagination is requested, return a paginated JSON response
        if($paginate){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, JoursFeries::paginate($perPage));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, JoursFeries::all());
    }
}