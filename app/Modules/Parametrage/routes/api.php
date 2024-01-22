<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Parametrage\Http\Controllers\TemplateController;
use App\Modules\Parametrage\Http\Controllers\TypeCongeController;
use App\Modules\Parametrage\Http\Controllers\JoursFeriesController;
use App\Modules\Parametrage\Http\Controllers\JoursTravailController;
use App\Modules\Parametrage\Http\Controllers\TemplateVariableController;
use App\Modules\Parametrage\Http\Controllers\WorkflowValidationController;
use App\Modules\Parametrage\Http\Controllers\ParametrageDeValeurController;


// This is the group of JoursFeries
Route::group(['prefix' => 'api'], function () {

    Route::post('jours-feries/create', [JoursFeriesController::class, 'create']);
    Route::put('jours-feries/{joursFeries}/update', [JoursFeriesController::class, 'update']);
    Route::delete('jours-feries/{joursFeries}/delete', [JoursFeriesController::class, 'delete']);
    Route::get('jours-feries', [JoursFeriesController::class, 'getAll']);
    Route::get('jours-feries/{joursFeries}', [JoursFeriesController::class, 'getOne']);

});
// This is the group of JoursTravail
Route::group(['prefix' => 'api'], function () {
    Route::put('jours-travail/{jourTravail}/update', [JoursTravailController::class, 'switch']);
    Route::get('jours-travail', [JoursTravailController::class, 'getAll']);

});
// This is the group of TypeConge
Route::group(['prefix' => 'api'], function () {
    Route::post('type-conge/create', [TypeCongeController::class, 'create']);
    Route::put('type-conge/{typeConge}/update', [TypeCongeController::class, 'update']);
    Route::get('type-conge', [TypeCongeController::class, 'getAll']);

});
// This is the group of ParametrageDeValeur
Route::group(['prefix' => 'api'], function () {
    Route::post('parametrage/create', [ParametrageDeValeurController::class, 'create']);
    Route::put('parametrage/{parametrage}/update', [ParametrageDeValeurController::class, 'update']);
    Route::get('parametrage', [ParametrageDeValeurController::class, 'getAll']);

});
// This is the group of WorkflowValidation
Route::group(['prefix' => 'api'], function () {
    Route::post('workflow-validation/create', [WorkflowValidationController::class, 'create']);
    Route::get('workflow-validation', [WorkflowValidationController::class, 'getAll']);

});
// This is the group of Template
Route::group(['prefix' => 'api'], function () {
    Route::post('templates/create', [TemplateController::class, 'create']);
});
// This is the group of Template variable
Route::group(['prefix' => 'api'], function () {
    Route::post('templates/set-variables', [TemplateVariableController::class, 'setVariables']);
});
