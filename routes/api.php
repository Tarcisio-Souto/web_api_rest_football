<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\v1\TeamsController;
use App\Http\Controllers\API\v1\EmployeesController;
use App\Http\Controllers\API\v1\PositionsController;
use App\Http\Controllers\API\v1\StatesController;
use Illuminate\Support\Facades\Route;



Route::post('login', [AuthApiController::class, 'login']);
Route::post('logout', [AuthApiController::class, 'logout']);
Route::post('refresh', [AuthApiController::class, 'refresh']);
Route::post('me', [AuthApiController::class, 'me']);


Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {

    Route::get('teams/{id}/employees', [TeamsController::class, "employees"]);
    Route::get('employees/{id}/team', [EmployeesController::class, "team"]);
    Route::get('positions/{id}/employees', [PositionsController::class, "employees"]);
    Route::get('states/{id}/teams', [StatesController::class, "teams"]);
    
    Route::apiResource('teams', TeamsController::class);
    Route::apiResource('employees', EmployeesController::class);
    Route::apiResource('positions', PositionsController::class);
    Route::apiResource('states', StatesController::class);
    
});

