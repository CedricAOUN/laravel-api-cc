<?php

use App\Http\Controllers\API\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index']);
Route::post('/books/create', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}/edit', [BookController::class, 'update']);
Route::delete('/books/{id}/delete', [BookController::class, 'destroy']);
