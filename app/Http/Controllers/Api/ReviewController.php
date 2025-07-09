<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['book', 'user'])->paginate(10);
        return response()->json($reviews);
    }

    public function show($id)
    {
        $review = Review::with(['book', 'user'])->findOrFail($id);
        return response()->json($review);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'nullable|exists:users,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $review = Review::create($request->only(['book_id', 'user_id', 'content', 'rating']));
        return response()->json([
            'status' => 'success',
            'review' => $review,
            'message' => 'Review created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'content' => 'sometimes|required|string',
            'rating' => 'sometimes|required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $review->update($request->only(['content', 'rating']));
        return response()->json([
            'status' => 'success',
            'review' => $review,
            'message' => 'Review updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Review deleted successfully',
        ]);
    }
}
