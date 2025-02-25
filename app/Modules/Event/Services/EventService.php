<?php

namespace App\Modules\Event\Services;
use UploadHelper;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\DB;
use App\Modules\Event\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Modules\Event\Http\Resources\EventResource;
use App\Modules\Event\Http\Resources\EventCollection;

class EventService
{
    use CustomResponse;
    
    // This function is for (Update & Create)
    public function create($data, $event = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new Event model instance with the validated request data
                if($event){
                    $event->update($data);
                    $created_event = $event->fresh();
                }else{
                    $created_event = Event::create($data);
                }

                // Check if request has the picture
                if(isset($data['picture'])){
                    // Upload the photo file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($data['picture'], 'events/photos/'.$created_event->uuid)[0];
                    // Set the photo filename on the Event model and save it
                    $created_event->picture = $filename;
                    $created_event->save();
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created event object
            return $this->jsonResponse(true, 200, 200, new EventResource($created_event));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($event){
        $event->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($event){
        // Get the relationships for the Event model
        $relations = $event->relations(true);
        // Retrieve the Event model and related models using the specified relations
        $event = Event::with($relations)->find($event->id);
        // Return a JSON response with the retrieved Event model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new EventResource($event) ?: []);
    }

    public function getAll($request){
        // Get the relationships for the Event model
        $relations = Event::relations();
        // Build a query with the Event model and its relationships
        $query = Event::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->per_page)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new EventCollection($query->paginate($request->per_page)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new EventCollection($query->get()));
    }
}