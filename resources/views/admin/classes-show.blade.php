@extends('layouts.admin')

@section('title', 'Class Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><i class="fas fa-school me-2"></i>Class Details</h1>
    <div>
        <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i>Edit</a>
        <a href="{{ route('admin.classes') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Class Name</div>
                    <div class="col-sm-8 fw-semibold">{{ $class->class_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Section</div>
                    <div class="col-sm-8">{{ $class->section ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Class Teacher</div>
                    <div class="col-sm-8">{{ $class->teacher->first_name ?? 'N/A' }} {{ $class->teacher->last_name ?? '' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted">Capacity</div>
                    <div class="col-sm-8">{{ $class->capacity }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4 text-muted">Status</div>
                    <div class="col-sm-8">
                        <span class="badge bg-{{ $class->status ? 'success' : 'danger' }}">
                            {{ $class->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-users me-1"></i>Students ({{ $class->students->count() }})</h6></div>
            <div class="card-body" style="max-height:300px;overflow-y:auto;">
                @forelse($class->students as $student)
                    <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                        <div>
                            <span class="fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</span>
                            <br><small class="text-muted">{{ $student->admission_number }}</small>
                        </div>
                        <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                    </div>
                @empty
                    <p class="text-muted mb-0">No students enrolled.</p>
                @endforelse
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light"><h6 class="mb-0"><i class="fas fa-trash me-1"></i>Danger Zone</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this class?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100"><i class="fas fa-trash me-1"></i>Delete Class</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
