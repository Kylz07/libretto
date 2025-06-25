<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

Route::redirect('/', '/books');
Route::resource('books', BookController::class);

Route::resource('authors', AuthorController::class)->only(['index']);
