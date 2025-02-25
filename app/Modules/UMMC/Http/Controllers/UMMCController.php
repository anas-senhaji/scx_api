<?php

namespace App\Modules\UMMC\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UMMCController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("UMMC::welcome");
    }
}
