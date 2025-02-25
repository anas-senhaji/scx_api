<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Player\Http\Controllers\PlayerController;


Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::post('players/create', [PlayerController::class, 'create']);
    Route::put('players/{player}/update', [PlayerController::class, 'update']);
    Route::delete('players/{player}/delete', [PlayerController::class, 'delete']);
    Route::get('players', [PlayerController::class, 'getAll']);
    Route::get('players/{player}', [PlayerController::class, 'getOne']);
    Route::get('players/{tournament}/eligible', [PlayerController::class, 'getEligiblePlayersForTournament']);

});