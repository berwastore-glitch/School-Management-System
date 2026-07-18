@extends('layouts.app')

@section('title', 'Dashboard - SchoolMS')

@section('content')
@php
    $user = Auth::user();
    $isAdmin = in_array($user->role ?? '', ['admin', 'super_admin']);
    $isTeacher = $user->role === 'teacher';
    $isStudent = $user->role === 'student';
@endphp

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:50px;height:50px;border-radius:12px;background:#DBEAFE;color:#2563EB;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:#0A2342;">{{ $user->name }}</div>
                    <div style="font-size:0.85rem;color:#6B7280;">{{ ucfirst($user->role ?? 'User') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:50px;height:50px;border-radius:12px;background:#FEF3C7;color:#D97706;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <div style="font-size:0.95rem;font-weight:600;color:#0A2342;">{{ $user->email }}</div>
                    <div style="font-size:0.85rem;color:#6B7280;">Email Address</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div style="width:50px;height:50px;border-radius:12px;background:#D1FAE5;color:#10B981;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <div style="font-size:0.95rem;font-weight:600;color:#0A2342;">Active</div>
                    <div style="font-size:0.85rem;color:#6B7280;">Account Status</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($isAdmin)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 style="font-weight:700;color:#0A2342;">Welcome, {{ $user->name }}!</h5>
            <p class="text-muted mt-2">You are logged in as <strong>{{ ucfirst($user->role) }}</strong>.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-orange mt-2"><i class="fas fa-tachometer-alt me-1"></i> Go to Admin Dashboard</a>
        </div>
    </div>
@elseif($isTeacher)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 style="font-weight:700;color:#0A2342;">Welcome, {{ $user->name }}!</h5>
            <p class="text-muted mt-2">You are logged in as <strong>Teacher</strong>. Use the menu above to navigate.</p>
        </div>
    </div>
@elseif($isStudent)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 style="font-weight:700;color:#0A2342;">Welcome, {{ $user->name }}!</h5>
            <p class="text-muted mt-2">You are logged in as <strong>Student</strong>. Use the menu above to navigate.</p>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 style="font-weight:700;color:#0A2342;">Welcome, {{ $user->name }}!</h5>
            <p class="text-muted mt-2">You are logged in as <strong>{{ ucfirst($user->role ?? 'User') }}</strong>.</p>
        </div>
    </div>
@endif
@endsection
