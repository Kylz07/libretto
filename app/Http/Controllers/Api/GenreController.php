<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::paginate(10);
        return response()->json($genres);
    }

    public function show($id)
    {
        $genre = Genre::with('books')->findOrFail($id);
        return response()->json($genre);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $genre = Genre::create($request->only(['name']));
        return response()->json([
            'status' => 'success',
            'genre' => $genre,
            'message' => 'Genre created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:genres,name,' . $id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $genre->update($request->only(['name']));
        return response()->json([
            'status' => 'success',
            'genre' => $genre,
            'message' => 'Genre updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Genre deleted successfully',
        ]);
    }
}
