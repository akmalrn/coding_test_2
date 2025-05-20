<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $author_id = $request->input('author_id');

        $books = Book::query()->with('author');

        if ($query) {
            $books->where('title', 'like', "%$query%")
                ->orWhere('isbn', 'like', "%$query%");
        }

        if ($author_id) {
            $books->where('author_id', $author_id);
        }

        $books = $books->paginate(10)->appends([
            'query' => $query,
            'author_id' => $author_id
        ]);

        $authors = Author::all();

        return view('books.index', compact('books', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'required|string|max:20|unique:books',
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        Book::create($request->only(['isbn', 'title', 'author_id']));

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show($id): JsonResponse
    {
        $book = Book::with('author')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Buku tidak ditemukan.'], 404);
        }

        return response()->json([
            'id' => $book->id,
            'isbn' => $book->isbn,
            'title' => $book->title,
            'author' => [
                'first_name' => optional($book->author)->first_name,
                'last_name' => optional($book->author)->last_name,
            ],
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at,
        ], 200);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
        ]);

        $book->update($request->only(['isbn', 'title', 'author_id']));

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function searchById(Request $request): JsonResponse
    {
        $query = $request->input('query');

        $books = Book::where('title', 'like', "%$query%")
            ->orWhere('isbn', 'like', "%$query%")
            ->with('author')
            ->paginate(10);

        return response()->json($books);
    }

    public function getBooksByAuthorName(Request $request): JsonResponse
    {
        $author_id = $request->query('author_id');
    
        if (!$author_id) {
            return response()->json([
                'message' => 'Parameter author_id diperlukan.'
            ], 400); 
        }
    
        $author = Author::find($author_id);
    
        if (!$author) {
            return response()->json([
                'message' => 'Penulis tidak ditemukan.'
            ], 404);
        }
    
        $books = Book::where('author_id', $author_id)
            ->with('author')
            ->paginate(10);
    
        return response()->json($books);
    }
}
