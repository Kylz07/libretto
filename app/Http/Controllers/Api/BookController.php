<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    protected function errorResponse($message, $code = 400, $errors = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $code,
            'errors' => $errors,
        ], $code);
    }

    public function index()
    {
        $books = Book::with(['author', 'genres'])->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $books,
        ]);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'genres', 'reviews'])->find($id);
        if (!$book) {
            return $this->errorResponse('Book not found', 404);
        }
        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
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
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $book = Book::create($request->only(['title', 'author_id']));
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }
        return response()->json([
            'success' => true,
            'data' => $book->load(['author', 'genres']),
            'message' => 'Book created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return $this->errorResponse('Book not found', 404);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'genres' => 'array',
            'genres.*' => 'exists:genres,id',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $book->update($request->only(['title', 'author_id']));
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        }
        return response()->json([
            'success' => true,
            'data' => $book->load(['author', 'genres']),
            'message' => 'Book updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return $this->errorResponse('Book not found', 404);
        }
        $book->delete();
        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully',
        ]);
    }
}
