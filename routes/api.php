<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthorController,
    BookController,
    PublisherController,
};

Route::apiResource('books', BookController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('publishers', PublisherController::class);
