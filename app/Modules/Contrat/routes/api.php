<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Contrat\Http\Controllers\ContratController;

Route::group(['prefix' => 'api'], function () {

    Route::get('contrat', [ContratController::class, 'get']);

});