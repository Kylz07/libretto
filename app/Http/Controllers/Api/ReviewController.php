<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
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
        $reviews = Review::with(['book'])->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $reviews,
        ]);
    }

    public function show($id)
    {
        $review = Review::with(['book', 'user'])->find($id);
        if (!$review) {
            return $this->errorResponse('Review not found', 404);
        }
        return response()->json([
            'success' => true,
            'data' => $review,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $review = Review::create($request->only(['book_id', 'content', 'rating']));
        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return $this->errorResponse('Review not found', 404);
        }
        $validator = Validator::make($request->all(), [
            'content' => 'sometimes|required|string',
            'rating' => 'sometimes|required|integer|min:1|max:5',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $review->update($request->only(['content', 'rating']));
        return response()->json([
            'success' => true,
            'data' => $review,
            'message' => 'Review updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return $this->errorResponse('Review not found', 404);
        }
        $review->delete();
        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully',
        ]);
    }
}
