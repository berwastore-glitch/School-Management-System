@extends('layouts.teacher')

@section('title', 'Students')
@section('page_title', 'Students')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search students..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('teacher.exams.create') }}" class="btn btn-outline-orange"><i class="fas fa-file-alt me-1"></i>Create Exam</a>
        <a href="{{ route('teacher.students.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Add Student</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Admission No.</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-primary">{{ $student->admission_number }}</span></td>
                        <td>
                            <a href="{{ route('teacher.students.show', $student) }}" class="text-decoration-none fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</a>
                        </td>
                        <td>{{ $student->class->class_name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($student->gender ?? 'N/A') }}</td>
                        <td>
                            <span class="badge bg-{{ ($student->status ?? true) ? 'success' : 'danger' }}">
                                {{ ($student->status ?? true) ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('teacher.students.show', $student) }}" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('teacher.students.marks', $student) }}" class="btn btn-success" title="Enter Marks"><i class="fas fa-pen"></i></a>
                                <a href="{{ route('teacher.students.edit', $student) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('teacher.students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $students->links() }}</div>
@endsection
