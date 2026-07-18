@extends('layouts.admin')

@section('title', 'Teachers - SchoolMS Admin')
@section('page_title', 'Teachers Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Manage all teachers in the system</p>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i> Add New Teacher</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $teacher->employee_id }}</td>
                        <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                        <td>{{ $teacher->subject ?? 'N/A' }}</td>
                        <td>{{ $teacher->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $teacher->status ? 'success' : 'danger' }}">
                                {{ $teacher->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.teachers.show', $teacher) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No teachers found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $teachers->links() }}</div>
@endsection
