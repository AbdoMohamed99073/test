<?php

use App\Http\Controllers\Api\AccessTokenController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');






Route::apiResource('/apiproducts', ProductController::class);


Route::post('/access', [AccessTokenController::class , 'store'])
    ->middleware('guest:sanctum');
