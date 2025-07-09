<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre; 

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::paginate(10);
        return view('genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = \App\Models\Genre::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Genre already exists.']);
        }

        \App\Models\Genre::create(['name' => $validated['name']]);
        return redirect()->route('genres.index')->with('success', 'Genre added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('genres.show', compact('genre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genre = Genre::findOrFail($id);
        return view('genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = Genre::whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
            ->where('id', '!=', $genre->id)
            ->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Genre already exists.']);
        }

        try {
            $genre->update(['name' => $validated['name']]);
            return redirect()->route('genres.index')->with('success', 'Genre updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Failed to update genre.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);
        try {
            $genre->delete();
            return redirect()->route('genres.index')->with('success', 'Genre deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('genres.index')->with('error', 'Failed to delete genre.');
        }
    }
}
