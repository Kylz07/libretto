<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::paginate(10);
        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = Author::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Author already exists.']);
        }

        Author::create(['name' => $validated['name']]);
        return redirect()->route('authors.index')->with('success', 'Author added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::with('books')->withCount('books')->findOrFail($id);
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $author = Author::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Case-insensitive duplicate check, excluding current author
        $exists = Author::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
            ->where('id', '!=', $author->id)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Author already exists.']);
        }

        try {
            $author->update(['name' => $validated['name']]);
            return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Failed to update author.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);
        try {
            $author->delete();
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('authors.index')->with('error', 'Failed to delete author.');
        }
    }
}
