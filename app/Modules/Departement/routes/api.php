<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Departement\Http\Controllers\DepartementController;

Route::group(['prefix' => 'api'], function () {

    Route::post('departements/create', [DepartementController::class, 'create']);
    Route::put('departements/{departement}/update', [DepartementController::class, 'update']);
    Route::delete('departements/{departement}/delete', [DepartementController::class, 'delete']);
    Route::get('departements', [DepartementController::class, 'getAll']);
    Route::get('departements/{departement}', [DepartementController::class, 'getOne']);

});