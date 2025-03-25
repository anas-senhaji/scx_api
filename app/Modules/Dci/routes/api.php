<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Dci\Http\Controllers\DciController;


Route::group(['prefix' => 'api'], function () {

    Route::post('dci/import', [DciController::class, 'import']);
    Route::post('dci/stats/fetch',[DciController::class, 'fetch']);
    Route::get('dci/list',[DciController::class, 'getDcis']);
});