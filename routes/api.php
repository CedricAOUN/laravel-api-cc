<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::apiResource('books', BookController::class)->middleware('auth:sanctum');

Route::group(['prefix' => 'users'], function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
});
