@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">{{ $genre->name }}</h2>
        <div>
            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning btn-sm me-2 edit-genre-btn" title="Edit Genre">
                <i class="bi bi-pencil-square"></i>
            </a>
        </div>
    </div>
</div>
@endsection
