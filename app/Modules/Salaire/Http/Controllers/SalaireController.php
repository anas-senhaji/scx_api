<?php

namespace App\Modules\Salaire\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaireController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view("Salaire::welcome");
    }
}
