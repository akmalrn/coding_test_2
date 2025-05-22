<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('authors')->group(function () {
    Route::post('/', [AuthorController::class, 'store']);
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::get('{id}', [AuthorController::class, 'show']);
    Route::get('{id}/books', [AuthorController::class, 'books']);
});

Route::prefix('books')->group(function () {
    Route::post('/', [BookController::class, 'store']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('{id}', [BookController::class, 'show']);

    // Route yang menerima author_id lewat query parameter
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    // Route dengan URL parameter author_id
    Route::get('/authors/{author}/books', [BookController::class, 'booksByAuthor'])->name('books.by.author');
});
