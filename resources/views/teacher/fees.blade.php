@extends('layouts.teacher')

@section('title', 'Fees - SchoolMS')
@section('page_title', 'Fees')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Fee records for your class students</p>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees as $fee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fee->student->first_name ?? 'N/A' }} {{ $fee->student->last_name ?? '' }}</td>
                        <td>{{ $fee->fee_type }}</td>
                        <td>${{ number_format($fee->amount, 2) }}</td>
                        <td>{{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            @php
                                $badge = match($fee->payment_status) {
                                    'paid' => 'success',
                                    'pending' => 'warning',
                                    'overdue' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($fee->payment_status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No fee records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $fees->links() }}</div>
@endsection
