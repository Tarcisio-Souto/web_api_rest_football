<?php

use App\Http\Controllers\API\v1\TeamsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('teams', TeamsController::class);
});

