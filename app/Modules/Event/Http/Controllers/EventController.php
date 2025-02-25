<?php

namespace App\Modules\Event\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use App\Modules\Event\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Modules\Event\Services\EventService;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    use CustomResponse;
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'picture' => 'nullable',
            'discipline_id' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'place' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');

        $data = $validator->validated();
        $data['organizer_id'] = Auth::user()->userable->id;
        return $this->eventService->create($data);
    }

    public function update(Event $event, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'discipline_id' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'place' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');
        return $this->eventService->create($validator->validated(), $event);
    }

    public function delete(Event $event){
        return $this->eventService->delete($event);
    }

    public function getOne(Event $event){
        return $this->eventService->getOne($event);
    }
    
    public function getAll(Request $request){
        return $this->eventService->getAll($request);
    }
}
