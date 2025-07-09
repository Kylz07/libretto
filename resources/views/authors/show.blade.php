@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold mb-0">{{ $author->name }}</h2>
        <div>
            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning btn-sm me-2 edit-author-btn" title="Edit Author">
                <i class="bi bi-pencil-square"></i>
            </a>
        </div>
    </div>
    <div class="mb-4">
        <div class="d-flex align-items-center mb-2">
            <span class="fw-semibold">Works</span>
            <span class="ms-2 text-gray-500 small">({{ $author->books_count ?? $author->books()->count() }} books)</span>
        </div>
        <ul class="list-group">
            @forelse($author->books as $book)
                <li class="list-group-item">{{ $book->title }}</li>
            @empty
                <li class="list-group-item fst-italic text-muted">No books written</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection

@push('styles')
<style>
.text-gray-500 { color: #6c757d; }
.edit-author-btn:hover { background: #ffe066; color: #856404; }
.delete-author-btn:hover { background: #f8d7da; color: #721c24; }
.fw-bold { font-weight: bold; }
.fw-semibold { font-weight: 600; }
</style>
@endpush
