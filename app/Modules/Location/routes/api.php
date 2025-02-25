<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Location\Http\Controllers\LocationController;

Route::group(['prefix' => 'api'], function () {
    Route::get('countries', [LocationController::class, 'getAllCountries']);
});