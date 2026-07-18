@extends('layouts.student')

@section('title', 'My Results - SchoolMS')
@section('page_title', 'My Results')

@section('content')
@if($results->count())
<div class="card mb-4">
    <div class="card-header"><i class="fas fa-chart-bar me-2"></i>Results Summary</div>
    <div class="card-body">
        @php
            $avgMarks = $results->avg('marks_obtained');
            $highest = $results->max('marks_obtained');
            $lowest = $results->min('marks_obtained');
            $totalExams = $results->count();
        @endphp
        <div class="row text-center">
            <div class="col-md-3">
                <div class="fw-bold fs-4" style="color:#0A2342;">{{ number_format($avgMarks, 1) }}%</div>
                <div class="small text-muted">Average</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold fs-4" style="color:#10B981;">{{ number_format($highest, 1) }}%</div>
                <div class="small text-muted">Highest</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold fs-4" style="color:#EF4444;">{{ number_format($lowest, 1) }}%</div>
                <div class="small text-muted">Lowest</div>
            </div>
            <div class="col-md-3">
                <div class="fw-bold fs-4" style="color:#D97706;">{{ $totalExams }}</div>
                <div class="small text-muted">Total Results</div>
            </div>
        </div>
    </div>
</div>

@foreach($grouped as $examName => $examResults)
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-file-alt me-2"></i>{{ $examName }}</span>
        @if($examResults->first()->exam)
        <span class="text-muted small">
            {{ \Carbon\Carbon::parse($examResults->first()->exam->date)->format('M d, Y') }}
            | Term: {{ $examResults->first()->term ?? 'N/A' }}
        </span>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Marks Obtained</th>
                        <th>Grade</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examResults as $result)
                    @php
                        $m = $result->marks_obtained;
                        $g = $m >= 90 ? 'A+' : ($m >= 80 ? 'A' : ($m >= 70 ? 'B' : ($m >= 60 ? 'C' : ($m >= 50 ? 'D' : 'F'))));
                        $c = $m >= 70 ? 'success' : ($m >= 50 ? 'warning' : 'danger');
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->subject->subject_name ?? 'N/A' }}</td>
                        <td><strong>{{ $result->marks_obtained }}</strong></td>
                        <td><span class="badge bg-{{ $c }}">{{ $g }}</span></td>
                        <td>{{ $result->remark ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <td colspan="2" class="fw-bold">Exam Average</td>
                        <td class="fw-bold" colspan="3">{{ number_format($examResults->avg('marks_obtained'), 1) }}%</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endforeach
@else
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-file-alt text-muted mb-3" style="font-size:3rem;"></i>
        <h5 class="text-muted">No Results Yet</h5>
        <p class="text-muted">Your exam results will appear here once published.</p>
    </div>
</div>
@endif
@endsection
