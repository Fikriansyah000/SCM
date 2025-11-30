<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PestiMart - E-Commerce Mahasiswa')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Site Design System -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    
    <style>
        /* Legacy overrides - migrating to site.css */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            transition: transform var(--transition-fast);
        }
        
        .btn-primary:hover {
            background: var(--gradient-primary-hover);
            transform: translateY(-2px);
        }
        
        .card {
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-card);
            transition: transform var(--transition-base), box-shadow var(--transition-base);
        }
        
        @media (hover: hover) {
            .card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-card-hover);
            }
        }
        
        .form-control {
            border-radius: var(--radius-md);
            border: 1px solid var(--color-border);
            padding: var(--space-3) var(--space-4);
        }
        
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.2rem rgba(58, 123, 255, 0.25);
        }
        
        .alert {
            border-radius: var(--radius-md);
            border: none;
        }
        
        .badge-primary {
            background-color: var(--color-primary);
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @include('layouts.navbar')
    
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
        
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>
