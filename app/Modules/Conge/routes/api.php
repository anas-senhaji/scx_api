<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Conge\Http\Controllers\CongeController;

Route::group(['prefix' => 'api', 'middleware' => 'auth.jwt'], function () {

    Route::post('conges/create', [CongeController::class, 'create']);
    Route::put('conges/{conge}/update', [CongeController::class, 'update']);
    Route::put('conges/{conge}/validate', [CongeController::class, 'validateConge'])->middleware(['workflow.validation:CONGE']);
    Route::delete('conges/{conge}/delete', [CongeController::class, 'delete']);
    Route::get('conges', [CongeController::class, 'getAll']);
    Route::get('conges/{conge}', [CongeController::class, 'getOne']);

});