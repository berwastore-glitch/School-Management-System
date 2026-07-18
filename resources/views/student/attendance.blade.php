@extends('layouts.student')

@section('title', 'Attendance - SchoolMS')
@section('page_title', 'My Attendance')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-calendar"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalCount }}</div>
                <div class="stat-label">Total Days</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#D1FAE5;color:#10B981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="stat-number">{{ $presentCount }}</div>
                <div class="stat-label">Present</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEE2E2;color:#EF4444;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <div class="stat-number">{{ $absentCount }}</div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-number">{{ $lateCount }}</div>
                <div class="stat-label">Late</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-calendar-check me-2"></i>Attendance History</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Status</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $att)
                    <tr>
                        <td>{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($att->date)->format('l') }}</td>
                        <td>
                            <span class="badge bg-{{ $att->status === 'present' ? 'success' : ($att->status === 'late' ? 'warning' : 'danger') }}">
                                {{ ucfirst($att->status) }}
                            </span>
                        </td>
                        <td>{{ $att->remark ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No attendance records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center py-3">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
