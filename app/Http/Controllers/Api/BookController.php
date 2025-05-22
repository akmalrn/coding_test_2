<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('author_id')) {
            $authorId = $request->input('author_id');
            $books = Book::where('author_id', $authorId)->get();
        } else {
            $books = Book::all();
        }

        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|unique:books,isbn',
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        $validated['id'] = Str::uuid()->toString(); // kalau kamu pakai UUID

        $book = Book::create($validated);

        // Ambil info author biar dikembalikan dalam response
        $book->load('author');

        return response()->json([
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }


    public function show($id)
    {
        $book = Book::with('author')->find($id);

        if (!$book) {
            return response()->json([
                'message' => "Book not found with id: $id"
            ], 404);
        }


        return response()->json([
            'data' => [
                'id' => $book->id,
                'isbn' => $book->isbn,
                'title' => $book->title,
                'author' => $book->author
            ]
        ]);
    }

    public function booksByAuthor(Author $author)
    {
        $books = Book::where('author_id', $author->id)->get();

        return view('books.index', compact('books', 'author'));
    }
}
