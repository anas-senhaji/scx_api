<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Authentification\Http\Controllers\AuthentificationController;

Route::group(['prefix' => 'api/auth'], function () {

    Route::post('login', [AuthentificationController::class, 'login']);
    Route::post('register', [AuthentificationController::class, 'register']);
    Route::post('logout', [AuthentificationController::class, 'logout'])->middleware('auth.jwt');
    Route::get('me', [AuthentificationController::class, 'me'])->middleware('auth.jwt');

});