<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Collaborateur\Http\Controllers\CollaborateurController;

Route::group(['prefix' => 'api'], function () {

    Route::post('collaborateurs/create', [CollaborateurController::class, 'create']);
    Route::put('collaborateurs/{collaborateur}/update', [CollaborateurController::class, 'update']);
    Route::delete('collaborateurs/{collaborateur}/delete', [CollaborateurController::class, 'delete']);
    Route::get('collaborateurs', [CollaborateurController::class, 'getAll'])->middleware('auth.jwt');
    Route::get('collaborateurs/{collaborateur}', [CollaborateurController::class, 'getOne']);

});