@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-4">Edit Book</h2>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('books.update', $book->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="author_id" class="form-label">Author</label>
                    <select class="form-select" id="author_id" name="author_id" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Genres</label>
                    <div class="dropdown" id="genreDropdownWrapper">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="genreDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Genres
                        </button>
                        <ul class="dropdown-menu p-2" aria-labelledby="genreDropdown" style="min-width: 220px; max-height: 250px; overflow-y: auto;">
                            @foreach($genres as $genre)
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input genre-checkbox" type="checkbox" name="genres[]" id="genre_{{ $genre->id }}" value="{{ $genre->id }}" {{ in_array($genre->id, $selectedGenres, true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="genre_{{ $genre->id }}">
                                            {{ $genre->name }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="selected-genres" class="mt-2">
                        @foreach($genres as $genre)
                            @if(in_array($genre->id, $selectedGenres, true))
                                <span class="badge bg-primary me-1 mb-1 genre-badge" data-id="{{ $genre->id }}">
                                    {{ $genre->name }}
                                    <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-genre" aria-label="Remove" data-id="{{ $genre->id }}" style="font-size: 0.7em;"></button>
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dropdownToggle = document.getElementById('genreDropdown');
                    const dropdownMenu = document.querySelector('#genreDropdownWrapper .dropdown-menu');
                    const checkboxes = dropdownMenu.querySelectorAll('.genre-checkbox');
                    const selectedPanel = document.getElementById('selected-genres');
                    const genres = @json($genres);

                    // Use Bootstrap's dropdown, do not override show/hide

                    function updatePanel() {
                        selectedPanel.innerHTML = '';
                        checkboxes.forEach(function(checkbox) {
                            if (checkbox.checked) {
                                const genre = genres.find(g => g.id == checkbox.value || g.id == parseInt(checkbox.value));
                                if (!genre) return;
                                const span = document.createElement('span');
                                span.className = 'badge bg-primary me-1 mb-1 genre-badge';
                                span.innerHTML = genre.name +
                                    '<button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-genre" aria-label="Remove" data-id="' + genre.id + '" style="font-size: 0.7em;"></button>';
                                span.setAttribute('data-id', genre.id);
                                selectedPanel.appendChild(span);
                            }
                        });
                    }
                    checkboxes.forEach(cb => cb.addEventListener('change', updatePanel));
                    selectedPanel.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-genre')) {
                            const id = e.target.getAttribute('data-id');
                            checkboxes.forEach(cb => {
                                if (cb.value === id) cb.checked = false;
                            });
                            updatePanel();
                        }
                    });
                    // Initial render for already selected genres
                    updatePanel();
                });
                </script>
                <button type="submit" class="btn btn-primary">Update Book</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary ms-2">Back to List</a>
            </form>
        </div>
    </div>
</div>
@endsection
