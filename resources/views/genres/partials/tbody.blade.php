@foreach($genres as $index => $genre)
<tr id="genre-row-{{ $genre->id }}">
    <td>{{ ($genres->currentPage() - 1) * $genres->perPage() + $index + 1 }}</td>
    <td id="genre-name-{{ $genre->id }}">{{ $genre->name }}</td>
    <td>
        <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-sm btn-info me-1 view-genre-btn" title="View Details">
            <i class="bi bi-eye"></i>
        </a>
        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-warning me-1 edit-genre-btn" title="Edit">
            <i class="bi bi-pencil-square"></i>
        </a>
        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline delete-genre-form">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-sm btn-danger delete-genre-btn" data-bs-toggle="modal" data-bs-target="#deleteGenreModal" data-genre-id="{{ $genre->id }}" data-genre-name="{{ $genre->name }}">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </td>
</tr>
@endforeach
