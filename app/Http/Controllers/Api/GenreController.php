<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
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
        $genres = Genre::paginate(10);
        return response()->json([
            'success' => true,
            'data' => $genres,
        ]);
    }

    public function show($id)
    {
        $genre = Genre::with('books')->find($id);
        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }
        return response()->json([
            'success' => true,
            'data' => $genre,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $genre = Genre::create($request->only(['name']));
        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name,' . $id,
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $genre->update($request->only(['name']));
        return response()->json([
            'success' => true,
            'data' => $genre,
            'message' => 'Genre updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return $this->errorResponse('Genre not found', 404);
        }
        $genre->delete();
        return response()->json([
            'success' => true,
            'message' => 'Genre deleted successfully',
        ]);
    }
}
