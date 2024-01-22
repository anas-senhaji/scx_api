<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Role\Http\Controllers\RoleController;

Route::group(['prefix' => 'api'], function () {

    Route::post('roles/create', [RoleController::class, 'create']);
    Route::put('roles/{role}/update', [RoleController::class, 'update']);
    Route::delete('roles/{role}/delete', [RoleController::class, 'delete']);
    Route::get('roles', [RoleController::class, 'getAll']);
    Route::get('roles/{role}', [RoleController::class, 'getOne']);

});
