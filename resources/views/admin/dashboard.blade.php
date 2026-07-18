@extends('layouts.admin')

@section('title', 'Admin Dashboard - SchoolMS')
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
                <div class="stat-label">Total Students</div>
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
                <div class="stat-label">Total Classes</div>
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
                <a href="{{ route('admin.students') }}" class="btn btn-sm btn-outline-primary">View All</a>
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
                                    <span class="badge {{ $student->status ? 'badge-success' : 'badge-danger' }}">
                                        {{ $student->status ? 'Active' : 'Inactive' }}
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
                        <div class="fw-bold fs-4" style="color:#10B981;">{{ $paidFees ?? 0 }}</div>
                        <div class="small text-muted">Paid</div>
                    </div>
                    <div class="stat-box" style="border-left: 4px solid #D97706;">
                        <div class="fw-bold fs-4" style="color:#D97706;">{{ $pendingFees ?? 0 }}</div>
                        <div class="small text-muted">Pending</div>
                    </div>
                    <div class="stat-box" style="border-left: 4px solid #EF4444;">
                        <div class="fw-bold fs-4" style="color:#EF4444;">{{ $overdueFees ?? 0 }}</div>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Activity</span>
                <a href="{{ route('admin.activity-log') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivity ?? [] as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $log->user->name ?? 'System' }}</td>
                                <td>
                                    @php
                                        $actionBadge = match($log->action) {
                                            'created' => 'success',
                                            'updated' => 'warning',
                                            'deleted' => 'danger',
                                            'viewed' => 'info',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $actionBadge }}">{{ ucfirst($log->action) }}</span>
                                </td>
                                <td>{{ Str::limit($log->description ?? '', 60) }}</td>
                                <td>{{ $log->created_at ? $log->created_at->diffForHumans() : 'N/A' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No recent activity</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
            labels: {!! json_encode($attendanceMonths ?? ['Jan','Feb','Mar','Apr','May','Jun']) !!},
            datasets: [{
                label: 'Attendance %',
                data: {!! json_encode($attendancePcts ?? [0,0,0,0,0,0]) !!},
                borderColor: '#0A2342',
                backgroundColor: 'rgba(10,35,66,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, max: 100 } } }
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
                data: [{{ $paidFees ?? 0 }}, {{ $pendingFees ?? 0 }}, {{ $overdueFees ?? 0 }}],
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
