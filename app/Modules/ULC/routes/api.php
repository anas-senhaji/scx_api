<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\ULC\Http\Controllers\ULCController;

Route::group(['prefix' => 'api'], function () {

    Route::post('ulc/import', [ULCController::class, 'import']);
    Route::post('ulcs', [ULCController::class, 'getAll']);
});
