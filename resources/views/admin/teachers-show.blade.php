@extends('layouts.admin')

@section('title', 'Teacher Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><i class="fas fa-chalkboard-teacher me-2"></i>Teacher Details</h1>
    <div>
        <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.teachers') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Name</div>
                    <div class="col-sm-8 fw-semibold">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Employee ID</div>
                    <div class="col-sm-8"><span class="badge bg-primary">{{ $teacher->employee_id }}</span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Subject</div>
                    <div class="col-sm-8">{{ $teacher->subject ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Qualification</div>
                    <div class="col-sm-8">{{ $teacher->qualification ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Phone</div>
                    <div class="col-sm-8">{{ $teacher->phone ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Email</div>
                    <div class="col-sm-8">{{ $teacher->user->email ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Date of Birth</div>
                    <div class="col-sm-8">{{ $teacher->date_of_birth ? \Carbon\Carbon::parse($teacher->date_of_birth)->format('M d, Y') : 'N/A' }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-muted">Status</div>
                    <div class="col-sm-8">
                        <span class="badge bg-{{ $teacher->status ? 'success' : 'danger' }}">
                            {{ $teacher->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-info-circle me-1"></i>Additional Info</h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Address</span>
                    <span>{{ Str::limit($teacher->address ?? 'N/A', 30) }}</span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-trash me-1"></i>Danger Zone</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash me-1"></i>Delete Teacher</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
