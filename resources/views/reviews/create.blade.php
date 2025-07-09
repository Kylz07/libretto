@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h4 class="mb-1">Write a Review</h4>
                    <div class="text-muted small">for <span class="fw-bold">{{ $book->title }}</span> by {{ $book->author ? $book->author->name : 'N/A' }}</div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('reviews.store') }}" id="reviewForm">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <div class="mb-3">
    <label for="rating" class="form-label fw-semibold">Your Rating</label>
    <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
        <option value="">-- Select a rating --</option>
        <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>★★★★★ - Excellent</option>
        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>★★★★☆ - Good</option>
        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>★★★☆☆ - Average</option>
        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>★★☆☆☆ - Poor</option>
        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>★☆☆☆☆ - Terrible</option>
    </select>
    @error('rating')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                        <div class="mb-3">
                            <label for="content" class="form-label fw-semibold">What did you think?</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" placeholder="Share your thoughts..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</button>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i> Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
