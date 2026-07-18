@extends('layouts.student')

@section('title', 'Student Dashboard - SchoolMS')
@section('page_title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">
                <i class="fas fa-school"></i>
            </div>
            <div>
                <div class="stat-number" style="font-size:1.4rem;">{{ $student->class->class_name ?? 'N/A' }}</div>
                <div class="stat-label">My Class</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#D1FAE5;color:#10B981;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <div class="stat-number">{{ $attendancePct }}%</div>
                <div class="stat-label">Attendance</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalResults }}</div>
                <div class="stat-label">Results</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#EDE9FE;color:#7C3AED;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($pendingFees, 2) }}</div>
                <div class="stat-label">Pending Fees</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-user me-2"></i>My Info</div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Name</span>
                        <span class="fw-semibold">{{ $student->first_name }} {{ $student->last_name }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Admission No.</span>
                        <span class="fw-semibold">{{ $student->admission_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Class</span>
                        <span class="fw-semibold">{{ $student->class->class_name ?? 'N/A' }} {{ $student->class->section ?? '' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Class Teacher</span>
                        <span class="fw-semibold">{{ $student->class->teacher->first_name ?? 'N/A' }} {{ $student->class->teacher->last_name ?? '' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Email</span>
                        <span class="fw-semibold small">{{ $student->user->email ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Phone</span>
                        <span class="fw-semibold">{{ $student->phone ?? 'N/A' }}</span>
                    </div>
                </div>
                <hr>
                <a href="{{ route('student.class') }}" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-info-circle me-1"></i>View Full Class Info
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-alt me-2"></i>Recent Results</span>
                <a href="{{ route('student.results') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Marks</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentResults as $result)
                            <tr>
                                <td>{{ $result->exam->exam_name ?? 'N/A' }}</td>
                                <td>{{ $result->subject->subject_name ?? 'N/A' }}</td>
                                <td>{{ $result->marks_obtained }}</td>
                                <td>
                                    @php
                                        $grade = $result->marks_obtained >= 90 ? 'A+' : ($result->marks_obtained >= 80 ? 'A' : ($result->marks_obtained >= 70 ? 'B' : ($result->marks_obtained >= 60 ? 'C' : ($result->marks_obtained >= 50 ? 'D' : 'F'))));
                                        $color = $result->marks_obtained >= 70 ? 'success' : ($result->marks_obtained >= 50 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $grade }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No results yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-calendar-check me-2"></i>Recent Attendance</span>
                <a href="{{ route('student.attendance') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendance as $att)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $att->status === 'present' ? 'success' : ($att->status === 'late' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($att->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center py-4 text-muted">No attendance records</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-clipboard-list me-2"></i>Upcoming Exams</div>
            <div class="card-body">
                @forelse($upcomingExams as $exam)
                <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div>
                        <div class="fw-semibold small">{{ $exam->exam_name }}</div>
                        <div class="text-muted" style="font-size:0.8rem;">{{ $exam->subject->subject_name ?? 'General' }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-semibold small text-primary">{{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}</div>
                        <div class="text-muted" style="font-size:0.75rem;">Total: {{ $exam->total_marks }}</div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center mb-0 py-3">No upcoming exams</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-credit-card me-2"></i>Fee Summary</div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fw-bold fs-5" style="color:#10B981;">${{ number_format($paidFees, 2) }}</div>
                        <div class="small text-muted">Paid</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5" style="color:#D97706;">${{ number_format($pendingFees, 2) }}</div>
                        <div class="small text-muted">Pending</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5" style="color:#EF4444;">${{ number_format($totalFees - $paidFees - $pendingFees, 2) }}</div>
                        <div class="small text-muted">Overdue</div>
                    </div>
                </div>
                <hr>
                <a href="{{ route('student.fees') }}" class="btn btn-outline-orange btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>View Fee Details
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="fas fa-bolt me-2"></i>Quick Actions</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('student.results') }}" class="btn btn-orange">
                    <i class="fas fa-file-alt me-2"></i>View My Results
                </a>
                <a href="{{ route('student.attendance') }}" class="btn btn-outline-primary">
                    <i class="fas fa-calendar-check me-2"></i>View Attendance
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-user-cog me-2"></i>Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
