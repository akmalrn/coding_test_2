<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('author.index', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255'
        ]);

        $validated['id'] = Str::uuid()->toString();

        $author = Author::create($validated);

        return redirect()->route('authors.index')->with('success', 'Author has been added successfully.');
    }

    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => "Author with id: $id not found."
            ], 404);
        }

        return response()->json([
            'first_name' => $author->first_name,
            'last_name' => $author->last_name
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return redirect()->route('authors.index')->with('error', "Author with id: $id not found.");
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255'
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')->with('success', 'Author has been updated successfully.');
    }

     public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('success', 'Author berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $authors = Author::where('id', 'like', "%{$query}%")
            ->orWhere('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->get();

        if ($authors->isEmpty()) {
            return response()->json([
                'message' => 'No authors found matching your search.'
            ], 404);
        }

        return response()->json([
            'message' => 'Authors found.',
            'data' => $authors
        ], 200);
    }
}
