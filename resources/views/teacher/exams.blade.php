@extends('layouts.teacher')

@section('title', 'My Exams')
@section('page_title', 'My Exams')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Exams you have created for your class</p>
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
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->class->class_name ?? 'N/A' }}</td>
                        <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                        <td>{{ $exam->date ? \Carbon\Carbon::parse($exam->date)->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $exam->passing_marks }}/{{ $exam->total_marks }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No exams found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $exams->links() }}</div>
@endsection
