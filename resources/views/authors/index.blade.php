@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Authors</h1>
        <a href="{{ route('authors.create') }}" class="btn btn-success" id="addAuthorBtn">
            <i class="bi bi-plus-lg"></i> Add Author
        </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Works</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $index => $author)
                <tr id="author-row-{{ $author->id }}">
                    <td>{{ ($authors->currentPage() - 1) * $authors->perPage() + $index + 1 }}</td>
                    <td id="author-name-{{ $author->id }}">{{ $author->name }}</td>
                    <td>{{ $author->books_count ?? $author->books()->count() }} books</td>
                    <td>
                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-sm btn-info me-1 view-author-btn" title="View Details">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-author-btn" data-bs-toggle="modal" data-bs-target="#deleteAuthorModal" data-author-id="{{ $author->id }}" data-author-name="{{ $author->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $authors->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<div class="modal fade" id="deleteAuthorModal" tabindex="-1" aria-labelledby="deleteAuthorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteAuthorForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAuthorModalLabel">Delete Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="modalAuthorName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
