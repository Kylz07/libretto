<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['author', 'genres'])->paginate(12);
        $genres = Genre::all();
        return view('books.index', compact('books', 'genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        // Initialize selected genres as empty array
        $selectedGenres = [];
        // Pass authors, genres, and selected genres to the view
        // This allows the form to have empty checkboxes for genres
        return view('books.create', compact('authors', 'genres', 'selectedGenres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        try {
            $book = Book::create([
                'title' => $validated['title'],
                'author_id' => $validated['author_id'],
            ]);
            $book->genres()->sync($validated['genres']);
            return redirect()->route('books.index')->with('success', 'Book created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create book.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Eager load genres and author
        $book->load(['author', 'genres', 'reviews']);
        $averageRating = $book->reviews->avg('rating');
        return view('books.show', compact('book', 'averageRating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        // Get all authors and genres for dropdowns
        $authors = Author::all();
        $genres = Genre::all();
        // Get selected genre ids for the book
        $selectedGenres = $book->genres->pluck('id')->toArray();
        return view('books.edit', compact('book', 'authors', 'genres', 'selectedGenres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // Validate only title, author_id, genres
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        try {
            $book->update([
                'title' => $validated['title'],
                'author_id' => $validated['author_id'],
            ]);
            $book->genres()->sync($validated['genres']);
            // Redirect to books list with success message
            return redirect()->route('books.index')->with('success', 'Book updated successfully.');
        } catch (\Exception $e) {
            // Redirect back with error message
            return redirect()->back()->withInput()->with('error', 'Failed to update book.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('books.index')->with('error', 'Failed to delete book.');
        }
    }
}
