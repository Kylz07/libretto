<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
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
        $authors = Author::paginate(10);
        return response()->json($authors);
    }

    public function show($id)
    {
        $author = Author::with('books')->find($id);
        if (!$author) {
            return $this->errorResponse('Author not found', 404);
        }
        return response()->json($author);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $author = Author::create($request->only(['name']));
        return response()->json([
            'success' => true,
            'author' => $author,
            'message' => 'Author created successfully',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return $this->errorResponse('Author not found', 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name,' . $id,
        ]);
        if ($validator->fails()) {
            return $this->errorResponse('Validation error', 422, $validator->errors()->all());
        }
        $author->update($request->only(['name']));
        return response()->json([
            'success' => true,
            'author' => $author,
            'message' => 'Author updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return $this->errorResponse('Author not found', 404);
        }
        $author->delete();
        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully',
        ]);
    }
}
