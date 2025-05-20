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

        return redirect()->route('authors.index')->with('success', 'Penulis berhasil ditambahkan.');
    }

    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Penulis tidak ditemukan.'
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
            return redirect()->route('authors.index')->with('error', 'Penulis tidak ditemukan.');
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255'
        ]);

        $author->update($validated);

        return redirect()->route('authors.index')->with('success', 'Penulis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'message' => 'Penulis tidak ditemukan.'
            ], 404);
        }

        $author->delete();

        return response()->json([
            'message' => 'Penulis berhasil dihapus.'
        ]);
    }

    public function searchById(Request $request)
    {
        $query = $request->input('query');

        $authors = Author::where('id', 'like', "%{$query}%")->get();

        if ($authors->isEmpty()) {
            return response()->json([
                'message' => 'Penulis tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'message' => 'Penulis ditemukan.',
            'data' => $authors
        ]);
    }
}
