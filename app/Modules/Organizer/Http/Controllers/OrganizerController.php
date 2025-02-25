<?php

namespace App\Modules\Organizer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Organizer::welcome");
    }
}
