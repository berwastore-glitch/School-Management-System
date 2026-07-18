@extends('layouts.admin')

@section('title', 'Exams')
@section('page_title', 'Exams Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search exams..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('admin.exams') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Create Exam</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td><span class="badge bg-info">{{ $exam->subject->subject_name ?? 'N/A' }}</span></td>
                        <td>{{ $exam->class->class_name ?? 'N/A' }} {{ $exam->class->section ?? '' }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</td>
                        <td>{{ $exam->total_marks }} (Pass: {{ $exam->passing_marks }})</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this exam?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No exams found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $exams->links() }}</div>
@endsection
