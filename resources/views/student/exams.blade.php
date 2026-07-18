@extends('layouts.student')

@section('title', 'Exams - SchoolMS')
@section('page_title', 'Exams')

@section('content')
@if($exams->count())
<div class="card">
    <div class="card-header"><i class="fas fa-clipboard-list me-2"></i>Exam Schedule</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Total Marks</th>
                        <th>Passing Marks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subject->subject_name ?? 'General' }}</td>
                        <td>{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</td>
                        <td>{{ $exam->start_time ?? 'TBD' }} - {{ $exam->end_time ?? 'TBD' }}</td>
                        <td>{{ $exam->total_marks }}</td>
                        <td>{{ $exam->passing_marks }}</td>
                        <td>
                            @php
                                $isPast = \Carbon\Carbon::parse($exam->date)->isPast();
                                $status = $isPast ? 'completed' : ($exam->status === 'active' ? 'upcoming' : $exam->status);
                            @endphp
                            <span class="badge bg-{{ $status === 'completed' ? 'secondary' : ($status === 'upcoming' ? 'primary' : 'warning') }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-clipboard-list text-muted mb-3" style="font-size:3rem;"></i>
        <h5 class="text-muted">No Exams Scheduled</h5>
        <p class="text-muted">No exams have been scheduled for your class yet.</p>
    </div>
</div>
@endif
@endsection
