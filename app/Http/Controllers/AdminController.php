<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $authorsTotal = Author::count();
        $booksTotal = Book::count();
        return view('index', compact('authorsTotal', 'booksTotal'));
    }
}
