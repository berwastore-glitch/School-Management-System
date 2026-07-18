@extends('layouts.teacher')

@section('title', 'Classes - SchoolMS')
@section('page_title', 'Classes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">All classes in the system</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Section</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $class->class_name }}</td>
                        <td>{{ $class->section ?? 'N/A' }}</td>
                        <td>{{ $class->teacher->first_name ?? 'N/A' }} {{ $class->teacher->last_name ?? '' }}</td>
                        <td><span class="badge bg-info">{{ $class->students_count }}</span></td>
                        <td>
                            <span class="badge bg-{{ $class->status ? 'success' : 'danger' }}">
                                {{ $class->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No classes found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $classes->links() }}</div>
@endsection
