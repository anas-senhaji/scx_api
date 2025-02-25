<?php

namespace App\Modules\Team\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Team::welcome");
    }
}
