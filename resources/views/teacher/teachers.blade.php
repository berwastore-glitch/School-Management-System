@extends('layouts.teacher')

@section('title', 'Teachers - SchoolMS')
@section('page_title', 'Teachers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">All teachers in the system</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Phone</th>
                        <th>Status</th>
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
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No teachers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $teachers->links() }}</div>
@endsection
