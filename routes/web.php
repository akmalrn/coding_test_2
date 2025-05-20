<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');

    Route::resource('/dashboard/authors', AuthorController::class);
    Route::get('/authors/search', [AuthorController::class, 'searchById'])->name('authors.search');
    

    Route::resource('/dashboard/books', BookController::class);
    Route::get('/books/search', [BookController::class, 'searchById'])->name('books.search');
    Route::get('/books/by-author-name/', [BookController::class, 'getBooksByAuthorName'])->name('books.search.by.author');
});
