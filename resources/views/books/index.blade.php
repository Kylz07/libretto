@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0 text-3d5169">Browse Books</h5>
        <a href="{{ route('books.create') }}" class="btn btn-primary" style="background-color:rgb(11, 128, 50); border-color: #3d5169;">
            <i class="bi bi-plus-lg me-1"></i> Add Book
        </a>
    </div>

    {{-- Cards Grid --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        @foreach($books as $book)
        <div class="col">
            <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm hover-card" style="border-color: #d0e3f9;">
                    {{-- Book Cover Placeholder --}}
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background-color:rgb(234, 239, 244);">
                        <i class="bi bi-book" style="font-size: 3rem; color: #3d5169;"></i>
                    </div>
                    
                    <div class="card-body" style="background-color: white;">
                        {{-- Title --}}
                        <h5 class="card-title text-truncate text-3d5169" title="{{ $book->title }}">{{ $book->title }}</h5>
                        
                        {{-- Author --}}
                        <p class="card-text mb-1" style="color: #7598c1;">
                            <i class="bi bi-person me-1"></i>
                            {{ $book->author ? $book->author->name : 'N/A' }}
                        </p>
                        
                        {{-- Genres --}}
                        @if($book->genres->count())
                        <div class="mb-2">
                            @foreach($book->genres->take(2) as $genre)
                                <span class="badge me-1 mb-1" style="background-color: #c5b78a; color: #3d5169;">{{ $genre->name }}</span>
                            @endforeach
                            @if($book->genres->count() > 2)
                                <span class="badge" style="background-color: #d0e3f9; color: #3d5169;">+{{ $book->genres->count() - 2 }} more</span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $books->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>

<style>
    /* Custom color variables */
    :root {
        --primary-color: #496d96;
        --secondary-color: #7598c1;
        --light-bg: #d0e3f9;
        --dark-text: #3d5169;
        --accent-warm: #c5b78a;
    }
    
    /* Text colors */
    .text-3d5169 {
        color: #3d5169 !important;
    }
    
    /* Hover effect for cards */
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid #d0e3f9;
        background-color: white;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(61, 81, 105, 0.1);
        border-color: #7598c1;
    }
    
    /* Button styling */
    .btn-primary {
        background-color: #496d96;
        border-color: #3d5169;
    }
    
    .btn-primary:hover {
        background-color: #3d5169;
        border-color: #3d5169;
    }
    
    /* Pagination styling */
    .page-item.active .page-link {
        background-color: rgb(80, 97, 119);
        border-color: rgb(80, 97, 119);
    }
    
    .page-link {
        color: #496d96;
    }
    
    /* Ensure text colors remain consistent */
    .text-decoration-none:hover {
        text-decoration: none !important;
    }
    
    /* Click feedback */
    .hover-card:active {
        transform: translateY(-2px);
    }
</style>
@endsection