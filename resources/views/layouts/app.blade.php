<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Libretto Library</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Optional: Your custom CSS --}}
    <style>
        body {
            padding-top: 70px;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index') }}">📚 Libretto</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#librettoNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="librettoNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('authors.*') ? 'active' : '' }}" href="{{ route('authors.index') }}">Authors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('genres.*') ? 'active' : '' }}" href="{{ route('genres.index') }}">Genres</a>
                    </li>
                </ul>

                {{-- Future Auth --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a> {{-- Replace with real logout later --}}
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="container mt-4">
        @yield('content')
    </main>

    {{-- Bootstrap Bundle with JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
