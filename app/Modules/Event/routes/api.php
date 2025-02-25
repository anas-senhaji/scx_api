<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Event\Http\Controllers\EventController;

Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::post('events/create', [EventController::class, 'create']);
    Route::put('events/{event}/update', [EventController::class, 'update']);
    Route::delete('events/{event}/delete', [EventController::class, 'delete']);
    Route::get('events', [EventController::class, 'getAll']);
    Route::get('events/{event}', [EventController::class, 'getOne']);

});
