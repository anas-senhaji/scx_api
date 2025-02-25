<?php

namespace App\Modules\ULC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ULCController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("ULC::welcome");
    }
}
