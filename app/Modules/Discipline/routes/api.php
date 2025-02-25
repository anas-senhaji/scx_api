<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Discipline\Http\Controllers\DisciplineController;

Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    Route::post('disciplines/create', [DisciplineController::class, 'create']);
    Route::put('disciplines/{discipline}/update', [DisciplineController::class, 'update']);
    Route::delete('disciplines/{discipline}/delete', [DisciplineController::class, 'delete']);
    Route::get('disciplines', [DisciplineController::class, 'getAll']);
    Route::get('disciplines/{discipline}', [DisciplineController::class, 'getOne']);

});