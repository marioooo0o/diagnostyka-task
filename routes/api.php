<?php

use Illuminate\Support\Facades\Route;

Route::get('/categories/{category:name}/lab-tests', [App\Http\Controllers\LabTestController::class, 'getLabTestByCategory'])
    ->name('categories.lab-tests.index');
Route::apiResource('categories', App\Http\Controllers\CategoryController::class);
Route::apiResource('lab-tests', App\Http\Controllers\LabTestController::class);
