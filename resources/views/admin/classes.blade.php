@extends('layouts.admin')

@section('title', 'Classes - SchoolMS Admin')
@section('page_title', 'Classes Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Manage all classes in the system</p>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i> Add New Class</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Class Name</th>
                        <th>Section</th>
                        <th>Teacher</th>
                        <th>Students</th>
                        <th>Status</th>
                        <th>Actions</th>
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
                        <td>
                            <a href="{{ route('admin.classes.show', $class) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No classes found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $classes->links() }}</div>
@endsection
