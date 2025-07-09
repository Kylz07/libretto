<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::paginate(10);
        return response()->json($authors);
    }

    public function show($id)
    {
        $author = Author::with('books')->findOrFail($id);
        return response()->json($author);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $author = Author::create($request->only(['name']));
        return response()->json([
            'status' => 'success',
            'author' => $author,
            'message' => 'Author created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()->all(),
            ], 400);
        }
        $author->update($request->only(['name']));
        return response()->json([
            'status' => 'success',
            'author' => $author,
            'message' => 'Author updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Author deleted successfully',
        ]);
    }
}
