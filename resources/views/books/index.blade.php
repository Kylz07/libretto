@extends('layouts.app') {{-- Or create your own layout if none yet --}}

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">📚 Book List</h1>

    <div class="mb-4">
        <a href="{{ route('books.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            ➕ Add New Book
        </a>
    </div>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Author</th>
                <th class="border px-4 py-2">Genres</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td class="border px-4 py-2">{{ $book->title }}</td>
                    <td class="border px-4 py-2">{{ $book->author->name }}</td>
                    <td class="border px-4 py-2">
                        @foreach ($book->genres as $genre)
                            <span class="bg-gray-200 px-2 py-1 rounded text-sm">{{ $genre->name }}</span>
                        @endforeach
                    </td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('books.edit', $book) }}" class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this book?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center">No books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
