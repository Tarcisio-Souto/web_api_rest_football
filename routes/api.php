<?php

use App\Http\Controllers\API\v1\TeamsController;
use App\Http\Controllers\API\v1\EmployeesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {

    Route::get('teams/{id}/employees', [TeamsController::class, "employees"]);
    Route::get('employees/{id}/team', [EmployeesController::class, "team"]);

    Route::apiResource('teams', TeamsController::class);
    Route::apiResource('employees', EmployeesController::class);
});

