@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Books List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genres</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $index => $book)
                <tr>
                    <td>{{ ($books->currentPage() - 1) * $books->perPage() + $index + 1 }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author ? $book->author->name : 'N/A' }}</td>
                    <td>
                        @if($book->genres->count())
                            {{ $book->genres->pluck('name')->join(', ') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $books->links() }}
    </div>
</div>
@endsection
