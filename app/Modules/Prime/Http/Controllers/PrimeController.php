<?php

namespace App\Modules\Prime\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrimeController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Prime::welcome");
    }
}
