<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Groupe\Http\Controllers\GroupeController;

Route::group(['prefix' => 'api'], function () {

    Route::post('groupes/create', [GroupeController::class, 'create']);
    Route::put('groupes/{groupe}/update', [GroupeController::class, 'update']);
    Route::delete('groupes/{groupe}/delete', [GroupeController::class, 'delete']);
    Route::get('groupes', [GroupeController::class, 'getAll']);
    Route::get('groupes/{groupe}', [GroupeController::class, 'getOne']);

});