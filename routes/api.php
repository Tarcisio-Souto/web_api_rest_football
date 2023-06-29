<?php

use App\Http\Controllers\API\v1\TeamsController;
use App\Http\Controllers\API\v1\EmployeesController;
use App\Http\Controllers\API\v1\PositionsController;
use App\Http\Controllers\API\v1\StatesController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

    Route::get('teams/{id}/employees', [TeamsController::class, "employees"]);
    Route::get('employees/{id}/team', [EmployeesController::class, "team"]);
    Route::get('positions/{id}/employees', [PositionsController::class, "employees"]);
    Route::get('states/{id}/teams', [StatesController::class, "teams"]);
    
    Route::apiResource('teams', TeamsController::class);
    Route::apiResource('employees', EmployeesController::class);
    
});

