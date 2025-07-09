@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Genres</h1>
        <a href="{{ route('genres.create') }}" class="btn btn-success" id="addGenreBtn">
            <i class="bi bi-plus-lg"></i> Add Genre
        </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genres as $index => $genre)
                <tr id="genre-row-{{ $genre->id }}">
                    <td>{{ ($genres->currentPage() - 1) * $genres->perPage() + $index + 1 }}</td>
                    <td id="genre-name-{{ $genre->id }}">{{ $genre->name }}</td>
                    <td>
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning btn-sm me-2 edit-genre-btn" title="Edit Genre">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger delete-genre-btn" data-bs-toggle="modal" data-bs-target="#deleteGenreModal" data-genre-id="{{ $genre->id }}" data-genre-name="{{ $genre->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $genres->links('vendor.pagination.bootstrap-5') }}
    </div>

    <!-- Delete Genre Modal -->
    <div class="modal fade" id="deleteGenreModal" tabindex="-1" aria-labelledby="deleteGenreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteGenreForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteGenreModalLabel">Delete Genre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong id="modalGenreName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
