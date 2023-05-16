<?php

use Ikay\TheharvesterService\Http\Controllers\TheharvesterController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => config('theharvester-service.middleware',['web'])], function () {
Route::group(['middleware' => 'auth'], function () {
    
    Route::name('tasks.')->prefix('tasks')->group(function () {
        Route::resource('theharvesters', TheharvesterController::class)
            ->except(['destroy', 'edit', 'update']);
    });
    
});
});
