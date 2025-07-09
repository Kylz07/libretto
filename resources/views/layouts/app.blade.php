<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libretto - Your Literary Companion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/js/app.js'])
    <style>
        :root {
            --libretto-primary:rgb(80, 97, 119);
            --libretto-secondary: #6c757d;
            --libretto-accent: #ff914d;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            background-color: white !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--libretto-primary) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .navbar-brand i {
            color: var(--libretto-accent);
        }
        
        .nav-btn {
            border-radius: 50px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-width: 2px;
        }
        
        .nav-btn:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: none;
        }
        
        main {
            flex: 1;
            padding-bottom: 3rem;
        }
        
        footer {
            background-color: var(--libretto-primary);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/books">
                <i class="bi bi-book-half"></i>
                <span>Libretto</span>
            </a>
            
            <div class="d-flex align-items-center">
                <div class="d-none d-md-flex gap-2 me-4">
                    <a href="{{ route('authors.index') }}" class="btn btn-outline-primary nav-btn">
                        <i class="bi bi-people-fill me-1"></i>
                        Authors
                    </a>
                    <a href="{{ route('genres.index') }}" class="btn btn-outline-secondary nav-btn">
                        <i class="bi bi-tags-fill me-1"></i>
                        Genres
                    </a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                <div>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <div>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    
    <main class="container py-4">
        @yield('content')
    </main>
    
    <footer class="footer mt-auto">
        <div class="container text-center">
            <div class="d-flex justify-content-center gap-4 mb-3">
                <a href="#" class="text-white"><i class="bi bi-github fs-4"></i></a>
                <a href="#" class="text-white"><i class="bi bi-twitter fs-4"></i></a>
                <a href="#" class="text-white"><i class="bi bi-envelope fs-4"></i></a>
            </div>
            <p class="mb-0">© {{ date('Y') }} Libretto. All rights reserved.</p>
        </div>
    </footer>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert-dismissible.fade.show');
                alerts.forEach(function(alert) {
                    alert.classList.remove('show');
                    setTimeout(function() {
                        alert.remove();
                    }, 150);
                });
            }, 5000);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>