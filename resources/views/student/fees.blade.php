@extends('layouts.student')

@section('title', 'Fees - SchoolMS')
@section('page_title', 'My Fees')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#DBEAFE;color:#2563EB;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($totalAmount, 2) }}</div>
                <div class="stat-label">Total Fees</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#D1FAE5;color:#10B981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($paidAmount, 2) }}</div>
                <div class="stat-label">Paid</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($pendingAmount, 2) }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEE2E2;color:#EF4444;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($overdueAmount, 2) }}</div>
                <div class="stat-label">Overdue</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header"><i class="fas fa-credit-card me-2"></i>Fee Records</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Paid Date</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees as $fee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ ucfirst($fee->fee_type) }}</td>
                        <td>${{ number_format($fee->amount, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') }}</td>
                        <td>{{ $fee->paid_date ? \Carbon\Carbon::parse($fee->paid_date)->format('M d, Y') : '-' }}</td>
                        <td>{{ ucfirst($fee->payment_method ?? '-') }}</td>
                        <td>
                            @php
                                $statusColor = match($fee->payment_status) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'overdue' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">{{ ucfirst($fee->payment_status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No fee records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
