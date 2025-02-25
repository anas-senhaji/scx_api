<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Game\Http\Controllers\GameController;

Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::post('games/create', [GameController::class, 'create']);
    Route::put('games/{game}/update', [GameController::class, 'update']);
    Route::delete('games/{game}/delete', [GameController::class, 'delete']);
    Route::get('games', [GameController::class, 'getAll']);
    Route::get('game/{games}', [GameController::class, 'getOne']);
    Route::get('games/teams', [GameController::class, 'getAllTeamGames']);
    Route::get('games/players', [GameController::class, 'getAllPlayerGames']);

});