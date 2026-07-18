<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') - SchoolMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; }
        body { background: #F3F4F6; font-family: 'Inter', sans-serif; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: #0A2342; color: white; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 1000; }
        .sidebar-brand { padding: 20px; font-size: 1.3rem; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); display: block; color: white; text-decoration: none; }
        .sidebar-brand:hover { color: #D97706; }
        .sidebar .nav-link { color: rgba(255,255,255,0.7); padding: 12px 20px; display: flex; align-items: center; gap: 12px; transition: all 0.3s; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; background: rgba(255,255,255,0.08); border-left-color: #D97706; }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .main-content { margin-left: var(--sidebar-width); flex: 1; padding: 20px 30px; }
        .top-bar { background: white; padding: 15px 30px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; }
        .stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; }
        .stat-card .stat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
        .stat-card .stat-number { font-size: 1.8rem; font-weight: 700; color: #0A2342; }
        .stat-card .stat-label { font-size: 0.85rem; color: #6B7280; }
        .card { border: 1px solid #E5E7EB; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header { background: white; border-bottom: 1px solid #E5E7EB; padding: 15px 20px; font-weight: 600; }
        .btn-orange { background: #D97706; color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 500; transition: all 0.3s; }
        .btn-orange:hover { background: #B85D00; color: white; }
        .btn-outline-orange { background: transparent; color: #D97706; border: 1px solid #D97706; border-radius: 8px; padding: 8px 20px; font-weight: 500; transition: all 0.3s; }
        .btn-outline-orange:hover { background: #D97706; color: white; }
        @media (max-width: 767px) { .sidebar { width: 0; overflow: hidden; } .main-content { margin-left: 0; } .sidebar.show { width: var(--sidebar-width); } }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <div class="sidebar" id="sidebar">
            <a href="{{ route('student.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-user-graduate me-2"></i>Student Portal
            </a>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.class*') ? 'active' : '' }}" href="{{ route('student.class') }}">
                        <i class="fas fa-school"></i> My Class
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.results*') ? 'active' : '' }}" href="{{ route('student.results') }}">
                        <i class="fas fa-file-alt"></i> My Results
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.attendance*') ? 'active' : '' }}" href="{{ route('student.attendance') }}">
                        <i class="fas fa-calendar-check"></i> Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.exams*') ? 'active' : '' }}" href="{{ route('student.exams') }}">
                        <i class="fas fa-clipboard-list"></i> Exams
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('student.fees*') ? 'active' : '' }}" href="{{ route('student.fees') }}">
                        <i class="fas fa-credit-card"></i> Fees
                    </a>
                </li>
                <hr class="mx-3 text-white opacity-25">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user-cog"></i> My Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-globe"></i> View Website
                    </a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="main-content">
            <div class="top-bar">
                <div>
                    <button class="btn d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                        <i class="fas fa-bars"></i>
                    </button>
                    <span class="fw-semibold">@yield('page_title', 'Dashboard')</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-user-cog me-1"></i>Profile
                    </a>
                    <span class="badge bg-success">Student</span>
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;border:2px solid #10B981;">
                        @else
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
                                <i class="fas fa-user text-success small"></i>
                            </div>
                        @endif
                        <span class="text-muted small">{{ Auth::user()->name }}</span>
                    </div>
                </div>
            </div>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
