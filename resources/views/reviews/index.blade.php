@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-2xl font-bold mb-0">Book Reviews</h1>
        <form method="GET" action="{{ route('reviews.index') }}" class="d-flex align-items-center gap-2">
            <label for="book_id" class="me-2 text-xs text-gray-500">Filter by Book:</label>
            <select name="book_id" id="book_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Books</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" @if(isset($bookId) && $bookId == $book->id) selected @endif>
                        {{ $book->title }} @if($book->author) ({{ $book->author->name }}) @endif
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    @if($reviews->count())
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($reviews as $review)
        <div class="col">
            <div class="card h-100 shadow-sm border-0" style="height: 12rem; min-height: 12rem;">
                <div class="card-body d-flex flex-column justify-content-between h-100 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold text-gray-700 text-truncate" style="max-width: 180px;">{{ $review->book->title ?? 'Unknown Book' }}</div>
                            <div class="text-xs text-gray-500">by {{ $review->book->author->name ?? 'Unknown Author' }}</div>
                        </div>
                        <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-outline-info ms-2" title="View Details">
                            <i class="bi bi-eye"></i>
                        </a>
                    </div>
                    <div class="mb-1 text-xs text-gray-500">Rating: <span class="fw-bold text-dark">{{ $review->rating }}</span></div>
                    <div class="review-content text-gray-700 small" style="max-height: 3.5rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">
                        {{ $review->content }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $reviews->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </div>
    @else
        <div class="text-center mt-5">
            <span class="fst-italic text-muted">No reviews yet</span>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.text-gray-500 { color: #6c757d !important; }
.text-gray-700 { color: #495057 !important; }
.review-content { line-height: 1.5; }
.card { background: #fff; border-radius: 0.5rem; }
.card .btn-outline-info { position: absolute; top: 0.5rem; right: 0.5rem; }
</style>
@endpush
