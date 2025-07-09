@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Book Header Section -->
    <div class="row mb-5">
        <div class="col-md-3 mb-4 mb-md-0">
            <div class="book-cover-placeholder bg-light rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="height: 300px;">
                <i class="bi bi-book text-muted" style="font-size: 5rem;"></i>
            </div>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="display-5 fw-bold mb-3">{{ $book->title }}</h1>
                    <div class="d-flex align-items-center mb-3">
                        @if($averageRating)
                            <div class="rating-display me-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= round($averageRating) ? '-fill' : '' }} text-warning"></i>
                                @endfor
                                <span class="ms-2 fw-bold">{{ number_format($averageRating, 1) }}</span>
                            </div>
                        @else
                            <span class="text-muted">No ratings yet</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
            </div>

            <div class="book-meta mb-4">
                <div class="d-flex flex-wrap gap-4">
                    <div>
                        <h6 class="text-muted mb-1">Author</h6>
                        <p class="mb-0 fw-semibold">{{ $book->author ? $book->author->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Genres</h6>
                        <p class="mb-0 fw-semibold">
                            @if($book->genres->count())
                                {{ $book->genres->pluck('name')->join(', ') }}
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('reviews.create', $book->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Write Review
                </a>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" 
                        data-bs-target="#deleteModal" data-book-id="{{ $book->id }}" 
                        data-book-title="{{ $book->title }}" title="Delete">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Reviews</h3>
                <span class="badge bg-primary rounded-pill">{{ $book->reviews->count() }}</span>
            </div>

            @if($book->reviews->count())
                <div class="review-list">
                    @foreach($book->reviews as $review)
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="rating-display me-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                        @endfor
                                    </div>
                                    <span class="text-muted small">{{ $review->user->name ?? 'Anonymous' }}</span>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="review-content">
                                <p class="mb-0">{{ $review->content }}</p>
                            </div>
                            <div class="mt-2 d-flex gap-2">
                                <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-outline-warning" title="Edit Review">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-review-btn" data-bs-toggle="modal" data-bs-target="#deleteReviewModal" data-review-id="{{ $review->id }}" data-review-content="{{ Str::limit($review->content, 30) }}" title="Delete Review">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text display-5 text-muted mb-3"></i>
                    <h5 class="text-muted">No reviews yet</h5>
                    <p class="text-muted">Be the first to share your thoughts!</p>
                    <button class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i> Write Review
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteBookForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <strong id="modalBookTitle"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Review Delete Modal --}}
    <div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteReviewForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteReviewModalLabel">Delete Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this review?</p>
                        <blockquote class="blockquote small mb-0"><span id="modalReviewContent"></span></blockquote>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Book delete modal
            var deleteModal = document.getElementById('deleteModal');
            var deleteBookForm = document.getElementById('deleteBookForm');
            var modalBookTitle = document.getElementById('modalBookTitle');
            if (deleteModal) {
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var bookId = button.getAttribute('data-book-id');
                    var bookTitle = button.getAttribute('data-book-title');
                    deleteBookForm.action = "{{ url('/books') }}/" + bookId;
                    modalBookTitle.textContent = bookTitle;
                });
            }
            // Review delete modal
            var deleteReviewModal = document.getElementById('deleteReviewModal');
            var deleteReviewForm = document.getElementById('deleteReviewForm');
            var modalReviewContent = document.getElementById('modalReviewContent');
            document.querySelectorAll('.delete-review-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var reviewId = btn.getAttribute('data-review-id');
                    var reviewContent = btn.getAttribute('data-review-content');
                    deleteReviewForm.action = "{{ url('/reviews') }}/" + reviewId;
                    modalReviewContent.textContent = reviewContent;
                });
            });
        });
    </script>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .book-cover-placeholder {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        transition: transform 0.3s ease;
    }
    
    .book-cover-placeholder:hover {
        transform: scale(1.02);
    }
    
    .rating-display {
        font-size: 1.1rem;
        line-height: 1;
    }
    
    .review-item {
        transition: background-color 0.2s ease;
        padding: 1rem;
        border-radius: 0.5rem;
    }
    
    .review-item:hover {
        background-color:rgb(240, 241, 243);
    }
</style>
@endsection