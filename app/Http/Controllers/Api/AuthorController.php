<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        $validated['id'] = Str::uuid()->toString(); // sesuai yang kamu pakai tadi

        $author = Author::create($validated);

        return response()->json([
            'message' => 'Author created successfully',
            'data' => $author
        ], 201);
    }

    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        return response()->json([
            'data' => $author
        ]);
    }

    public function books($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'message' => 'Author not found'
            ], 404);
        }

        $books = $author->books()->select('isbn', 'title')->get();

        return response()->json([
            'author_id' => $id,
            'books' => $books
        ]);
    }
}
