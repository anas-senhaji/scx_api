<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Tournament\Http\Controllers\TournamentController;
use App\Modules\Tournament\Http\Controllers\TournamentTypeController;

Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::post('tournament-types/create', [TournamentTypeController::class, 'create']);
    Route::put('tournament-types/{tournamentType}/update', [TournamentTypeController::class, 'update']);
    Route::delete('tournament-types/{tournamentType}/delete', [TournamentTypeController::class, 'delete']);
    Route::get('tournament-types', [TournamentTypeController::class, 'getAll']);
    Route::get('tournament-types/{tournamentType}', [TournamentTypeController::class, 'getOne']);

});

Route::group(['prefix' => 'api'], function () {

    Route::post('tournaments/create', [TournamentController::class, 'create']);
    Route::put('tournaments/{tournament}/update', [TournamentController::class, 'update']);
    Route::delete('tournaments/{tournament}/delete', [TournamentController::class, 'delete']);
    Route::get('tournaments', [TournamentController::class, 'getAll']);
    Route::get('tournaments/{tournament}', [TournamentController::class, 'getOne']);
    Route::post('tournaments/assign', [TournamentController::class, 'assignToTournament']);
    Route::get('tournaments/{tournament}/draw', [TournamentController::class, 'tournamentDraw']);

});