<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Dci\Http\Controllers\DciController;


Route::group(['prefix' => 'api'], function () {

    Route::post('dci/import', [DciController::class, 'import']);
});