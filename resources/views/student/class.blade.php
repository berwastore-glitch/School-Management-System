@extends('layouts.student')

@section('title', 'My Class - SchoolMS')
@section('page_title', 'My Class')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><i class="fas fa-school me-2"></i>Class Information</div>
            <div class="card-body">
                @if($class)
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Class Name</label>
                        <div class="fw-semibold">{{ $class->class_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Section</label>
                        <div class="fw-semibold">{{ $class->section ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Capacity</label>
                        <div class="fw-semibold">{{ $class->capacity }} students</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Status</label>
                        <div><span class="badge bg-{{ $class->status ? 'success' : 'danger' }}">{{ $class->status ? 'Active' : 'Inactive' }}</span></div>
                    </div>
                    @if($class->curriculum)
                    <div class="col-md-6">
                        <label class="text-muted small">Curriculum</label>
                        <div class="fw-semibold">{{ $class->curriculum->name ?? 'N/A' }}</div>
                    </div>
                    @endif
                    @if($class->academicYear)
                    <div class="col-md-6">
                        <label class="text-muted small">Academic Year</label>
                        <div class="fw-semibold">{{ $class->academicYear->name ?? 'N/A' }}</div>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-exclamation-circle mb-2" style="font-size:2rem;"></i>
                    <p>You are not assigned to any class yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-chalkboard-teacher me-2"></i>Class Teacher</div>
            <div class="card-body text-center">
                @if($teacher)
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px;">
                    <i class="fas fa-user-tie text-primary" style="font-size:2rem;"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</h5>
                <p class="text-muted small mb-1">{{ $teacher->employee_id }}</p>
                @if($teacher->subject)
                <p class="text-muted small"><i class="fas fa-book me-1"></i>{{ $teacher->subject }}</p>
                @endif
                @if($teacher->phone)
                <p class="text-muted small"><i class="fas fa-phone me-1"></i>{{ $teacher->phone }}</p>
                @endif
                @else
                <p class="text-muted mb-0">No class teacher assigned</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($subjects->count())
<div class="card mb-4">
    <div class="card-header"><i class="fas fa-book me-2"></i>Subjects</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->code ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i>Classmates ({{ $classmates->count() }})</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Admission No.</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classmates as $mate)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mate->first_name }} {{ $mate->last_name }}</td>
                        <td>{{ $mate->admission_number }}</td>
                        <td>{{ $mate->user->email ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4 text-muted">No classmates</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
