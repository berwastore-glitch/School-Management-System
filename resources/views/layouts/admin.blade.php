<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SchoolMS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
        }
        body {
            background: #F3F4F6;
            font-family: 'Inter', sans-serif;
            padding-top: 0;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: #0A2342;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 20px;
            font-size: 1.3rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar-brand:hover { color: #D97706; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: #D97706;
        }
        .sidebar .nav-link i { width: 20px; text-align: center; }
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 20px 30px;
        }
        .top-bar {
            background: white;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 1px solid #E5E7EB;
        }
        .stat-card:hover { box-shadow: 0 5px 20px rgba(0,0,0,0.08); transform: translateY(-2px); }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .stat-card .stat-number { font-size: 1.8rem; font-weight: 700; color: #0A2342; }
        .stat-card .stat-label { font-size: 0.85rem; color: #6B7280; }
        .card { border: 1px solid #E5E7EB; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header { background: white; border-bottom: 1px solid #E5E7EB; padding: 15px 20px; font-weight: 600; }
        .page-title { font-size: 1.5rem; font-weight: 700; color: #0A2342; margin-bottom: 20px; }
        .table th { font-weight: 600; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-success { background: #D1FAE5; color: #065F46; padding: 5px 12px; border-radius: 20px; }
        .badge-warning { background: #FEF3C7; color: #92400E; padding: 5px 12px; border-radius: 20px; }
        .badge-danger { background: #FEE2E2; color: #991B1B; padding: 5px 12px; border-radius: 20px; }
        .chart-container { position: relative; height: 300px; width: 100%; }
        .btn-orange { background: #D97706; color: white; border: none; border-radius: 8px; padding: 8px 20px; font-weight: 500; transition: all 0.3s; }
        .btn-orange:hover { background: #B85D00; color: white; }
        .btn-outline-orange { background: transparent; color: #D97706; border: 1px solid #D97706; border-radius: 8px; padding: 8px 20px; font-weight: 500; transition: all 0.3s; }
        .btn-outline-orange:hover { background: #D97706; color: white; }
        .stat-box { flex: 1; padding: 15px; border-radius: 10px; text-align: center; border: 1px solid #E5E7EB; }
        @media (max-width: 767px) {
            .sidebar { width: 0; overflow: hidden; }
            .main-content { margin-left: 0; }
            .sidebar.show { width: var(--sidebar-width); }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <div class="sidebar" id="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-graduation-cap me-2"></i>SchoolMS
            </a>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.students*') ? 'active' : '' }}" href="{{ route('admin.students') }}">
                        <i class="fas fa-user-graduate"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.teachers*') ? 'active' : '' }}" href="{{ route('admin.teachers') }}">
                        <i class="fas fa-chalkboard-teacher"></i> Teachers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.classes*') ? 'active' : '' }}" href="{{ route('admin.classes') }}">
                        <i class="fas fa-school"></i> Classes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}" href="{{ route('admin.attendance') }}">
                        <i class="fas fa-calendar-check"></i> Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.subjects*') ? 'active' : '' }}" href="{{ route('admin.subjects') }}">
                        <i class="fas fa-book"></i> Subjects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.exams*') ? 'active' : '' }}" href="{{ route('admin.exams') }}">
                        <i class="fas fa-file-alt"></i> Exams
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.fees*') ? 'active' : '' }}" href="{{ route('admin.fees') }}">
                        <i class="fas fa-credit-card"></i> Fees
                    </a>
                </li>
                <hr class="mx-3 text-white opacity-25">
                <li class="nav-item">
                    <small class="text-uppercase text-white-50 px-3 fw-bold" style="font-size:0.7rem;letter-spacing:1px;">Academics</small>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.curriculums*') ? 'active' : '' }}" href="{{ route('admin.curriculums') }}">
                        <i class="fas fa-layer-group"></i> Curriculums
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.academic-years') || request()->routeIs('admin.academic-years.*') ? 'active' : '' }}" href="{{ route('admin.academic-years') }}">
                        <i class="fas fa-calendar-alt"></i> Academic Years
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.terms') || request()->routeIs('admin.terms.*') ? 'active' : '' }}" href="{{ route('admin.terms') }}">
                        <i class="fas fa-clock"></i> Terms
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.grade-levels') || request()->routeIs('admin.grade-levels.*') ? 'active' : '' }}" href="{{ route('admin.grade-levels') }}">
                        <i class="fas fa-sort-amount-up"></i> Grade Levels
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.grading-scales') || request()->routeIs('admin.grading-scales.*') ? 'active' : '' }}" href="{{ route('admin.grading-scales') }}">
                        <i class="fas fa-star"></i> Grading Scales
                    </a>
                </li>
                <hr class="mx-3 text-white opacity-25">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.activity-log') ? 'active' : '' }}" href="{{ route('admin.activity-log') }}">
                        <i class="fas fa-history"></i> Activity Log
                    </a>
                </li>
                <hr class="mx-3 text-white opacity-25">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('school.settings') ? 'active' : '' }}" href="{{ route('school.settings') }}">
                        <i class="fas fa-cog"></i> School Settings
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('school.select') }}">
                        <i class="fas fa-plus-circle"></i> New School
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
                    @if(isset($currentSchool))
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                            <i class="fas fa-school me-1"></i>{{ $currentSchool->name }}
                        </span>
                        <form method="POST" action="{{ route('school.deselect') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Switch School">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('school.select') }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-school me-1"></i>Select School
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-user-cog me-1"></i>Profile
                    </a>
                    <div class="d-flex align-items-center">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;border:2px solid #D97706;">
                        @else
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;">
                                <i class="fas fa-user text-primary small"></i>
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
