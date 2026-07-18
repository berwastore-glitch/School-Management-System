@extends('layouts.teacher')

@section('title', 'Teacher Dashboard - SchoolMS')
@section('page_title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalStudents ?? 0 }}</div>
                <div class="stat-label">My Students</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalTeachers ?? 0 }}</div>
                <div class="stat-label">Total Teachers</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#D1FAE5;color:#10B981;">
                <i class="fas fa-school"></i>
            </div>
            <div>
                <div class="stat-number">{{ $totalClasses ?? 0 }}</div>
                <div class="stat-label">My Classes</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#EDE9FE;color:#7C3AED;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($totalFees ?? 0, 2) }}</div>
                <div class="stat-label">Fees Collected</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Attendance Trends</div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Fee Collection Trends</div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="feeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Students</span>
                <a href="{{ route('teacher.students') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Admission No.</th>
                                <th>Class</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents ?? [] as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->first_name }} {{ $student->last_name ?? '' }}</td>
                                <td>{{ $student->admission_number ?? 'N/A' }}</td>
                                <td>{{ $student->class->class_name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ ($student->status ?? true) ? 'success' : 'danger' }}">
                                        {{ ($student->status ?? true) ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No recent students</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">Fee Collection Overview</div>
            <div class="card-body">
                <div class="d-flex gap-2 mb-4">
                    <div class="stat-box" style="border-left: 4px solid #10B981;">
                        <div class="fw-bold fs-4" style="color:#10B981;">{{ $feeStats['paid'] ?? 0 }}</div>
                        <div class="small text-muted">Paid</div>
                    </div>
                    <div class="stat-box" style="border-left: 4px solid #D97706;">
                        <div class="fw-bold fs-4" style="color:#D97706;">{{ $feeStats['pending'] ?? 0 }}</div>
                        <div class="small text-muted">Pending</div>
                    </div>
                    <div class="stat-box" style="border-left: 4px solid #EF4444;">
                        <div class="fw-bold fs-4" style="color:#EF4444;">{{ $feeStats['overdue'] ?? 0 }}</div>
                        <div class="small text-muted">Overdue</div>
                    </div>
                </div>
                <div class="chart-container" style="height:180px;">
                    <canvas id="feeDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-history me-2"></i>Recent Activity</span>
                <span class="badge bg-info">Last 10 actions</span>
            </div>
            <div class="card-body">
                @forelse($recentActivity as $log)
                    <div class="d-flex align-items-start py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="bg-{{ $log->action === 'created' ? 'success' : ($log->action === 'updated' ? 'warning' : ($log->action === 'deleted' ? 'danger' : 'primary')) }} bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width:36px;height:36px;">
                            <i class="fas fa-{{ $log->action === 'created' ? 'plus' : ($log->action === 'updated' ? 'edit' : ($log->action === 'deleted' ? 'trash' : 'eye')) }} small text-{{ $log->action === 'created' ? 'success' : ($log->action === 'updated' ? 'warning' : ($log->action === 'deleted' ? 'danger' : 'primary')) }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small fw-semibold">{{ $log->user->name ?? 'System' }} <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">{{ ucfirst($log->user->role ?? '') }}</span></div>
                            <div class="small text-muted">{{ $log->description }}</div>
                        </div>
                        <small class="text-muted ms-2 flex-shrink-0">{{ $log->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p class="text-muted mb-0">No recent activity.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="fas fa-bolt me-2"></i>Quick Actions</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('teacher.attendance.mark') }}" class="btn btn-orange">
                    <i class="fas fa-calendar-check me-2"></i>Mark Attendance
                </a>
                <a href="{{ route('teacher.exams.create') }}" class="btn btn-outline-primary">
                    <i class="fas fa-plus me-2"></i>Create Exam
                </a>
                <a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-users me-2"></i>View Students
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('attendanceChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Attendance %',
                data: [92, 88, 95, 90, 93, 96],
                borderColor: '#0A2342',
                backgroundColor: 'rgba(10,35,66,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('feeChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Fees Collected ($)',
                data: {!! json_encode($monthlyFees && count($monthlyFees) ? array_values($monthlyFees) : [0,0,0,0,0,0]) !!},
                backgroundColor: '#D97706',
                borderRadius: 6
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('feeDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Pending', 'Overdue'],
            datasets: [{
                data: [{{ $feeStats['paid'] ?? 0 }}, {{ $feeStats['pending'] ?? 0 }}, {{ $feeStats['overdue'] ?? 0 }}],
                backgroundColor: ['#10B981', '#D97706', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { position: 'bottom', labels: { padding: 10, usePointStyle: true } } }
        }
    });
});
</script>
@endpush
