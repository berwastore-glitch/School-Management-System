@extends('layouts.teacher')

@section('title', 'Results')
@section('page_title', 'Exam Results')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Enter and manage student marks for exams</p>
    <a href="{{ route('teacher.exams.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Create Exam</a>
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
                        <th>Total Marks</th>
                        <th>Passing Marks</th>
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
                        <td>{{ $exam->total_marks }}</td>
                        <td>{{ $exam->passing_marks }}</td>
                        <td>
                            <a href="{{ route('teacher.results.marks', $exam) }}" class="btn btn-sm btn-orange">
                                <i class="fas fa-pen me-1"></i>Enter Marks
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No exams found for your classes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $exams->links() }}</div>
@endsection
