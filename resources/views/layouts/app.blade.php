<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SchoolMS'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0A2342;
            --primary-light: #1a3a6a;
            --secondary: #D97706;
            --secondary-dark: #b45309;
            --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        body {
            font-family: var(--font-family);
            background: #f8fafc;
            min-height: 100vh;
        }
        .app-navbar {
            background: var(--primary);
            padding: 0.75rem 0;
        }
        .app-navbar .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff !important;
            text-decoration: none;
        }
        .app-navbar .navbar-brand i { color: var(--secondary); margin-right: 0.4rem; }
        .app-navbar .navbar-brand span { color: var(--secondary); }
        .app-navbar .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 0.85rem !important;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .app-navbar .nav-link:hover,
        .app-navbar .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.08);
        }
        .app-navbar .btn-logout {
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.2);
            font-size: 0.85rem;
            padding: 0.35rem 1rem;
            border-radius: 8px;
            background: transparent;
            transition: all 0.2s;
        }
        .app-navbar .btn-logout:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-color: rgba(255,255,255,0.4);
        }
        .app-navbar .user-badge {
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .app-navbar .user-badge .role-badge {
            background: var(--secondary);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .app-content { padding: 2rem 0; }
        .navbar-divider {
            width: 1px;
            height: 24px;
            background: rgba(255,255,255,0.15);
            margin: 0 0.25rem;
        }
        @media (max-width: 991.98px) {
            .navbar-divider { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @php
        $user = Auth::user();
        $isAdmin = in_array($user->role ?? '', ['admin', 'super_admin']);
        $isTeacher = $user->role === 'teacher';
        $isStudent = $user->role === 'student';
    @endphp

    <nav class="navbar navbar-expand-lg app-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i>
                School<span>MS</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#appNav" aria-controls="appNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="appNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if($isAdmin)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Admin Panel
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-globe me-1"></i> Website
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-cog me-1"></i> Profile
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="user-badge">
                        <span class="role-badge">{{ ucfirst($user->role ?? 'User') }}</span>
                        <span>{{ $user->name }}</span>
                    </div>
                    <div class="navbar-divider d-none d-lg-block"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="app-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
