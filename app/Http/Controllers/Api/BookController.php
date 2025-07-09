<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'genres'])->paginate(10);
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'genres', 'reviews'])->findOrFail($id);
        return response()->json($book);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $book = Book::create($request->only(['title', 'author_id']));
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }
        return response()->json([
            'status' => 'success',
            'book' => $book->load(['author', 'genres']),
            'message' => 'Book created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $book->update($request->only(['title', 'author_id']));
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }
        return response()->json([
            'status' => 'success',
            'book' => $book->load(['author', 'genres']),
            'message' => 'Book updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Book deleted successfully',
        ]);
    }
}
