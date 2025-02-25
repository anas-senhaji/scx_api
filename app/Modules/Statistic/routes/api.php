<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Statistic\Http\Controllers\StatisticController;


Route::group(['prefix' => 'api'], function () {

    Route::post('statistic/import', [StatisticController::class, 'import']);
    Route::post('statistic/fetch', [StatisticController::class, 'fetch']);
});