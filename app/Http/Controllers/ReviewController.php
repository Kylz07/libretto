<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Book;
use App\Models\Author;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = Book::with('author')->orderBy('title')->get();
        $bookId = $request->input('book_id');
        $reviewsQuery = Review::with(['book.author']);
        if ($bookId) {
            $reviewsQuery->where('book_id', $bookId);
        }
        $reviews = $reviewsQuery->latest()->paginate(12);
        return view('reviews.index', compact('reviews', 'books', 'bookId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($bookId)
    {
        $book = Book::with('author')->findOrFail($bookId);
        return view('reviews.create', compact('book'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        try {
            Review::create($validated);
            return redirect()->route('books.show', $validated['book_id'])->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.show', $validated['book_id'])->with('error', 'Failed to submit review.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::with('book.author')->findOrFail($id);
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $review = Review::findOrFail($id);
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        try {
            $review->update($validated);
            return redirect()->route('books.show', $review->book_id)->with('success', 'Review updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.show', $review->book_id)->with('error', 'Failed to update review.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::findOrFail($id);
        $bookId = $review->book_id;
        try {
            $review->delete();
            return redirect()->route('books.show', $bookId)->with('success', 'Review deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('books.show', $bookId)->with('error', 'Failed to delete review.');
        }
    }
}
