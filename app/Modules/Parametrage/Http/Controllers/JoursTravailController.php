<?php

namespace App\Modules\Parametrage\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Modules\Parametrage\Models\JoursTravail;
use App\Modules\Parametrage\Services\JoursTravailService;

class JoursTravailController extends Controller
{
    protected $joursTravailService;

    public function __construct(JoursTravailService $joursTravailService){
        $this->joursTravailService = $joursTravailService;
    }

    public function switch(JoursTravail $jourTravail){
        return $this->joursTravailService->switch($jourTravail);
    }

    public function getAll(){
        return $this->joursTravailService->getAll();
    }
}
