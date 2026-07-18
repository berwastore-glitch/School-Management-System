@extends('layouts.admin')

@section('title', 'Fees - SchoolMS Admin')
@section('page_title', 'Fees Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Manage fee collections and payments</p>
    <a href="{{ route('admin.fees.record') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i> Record Payment</a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#D1FAE5;color:#10B981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <div class="stat-number">{{ $paidCount ?? 0 }}</div>
                <div class="stat-label">Paid</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEF3C7;color:#D97706;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <div class="stat-number">{{ $pendingCount ?? 0 }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#FEE2E2;color:#EF4444;">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <div class="stat-number">{{ $overdueCount ?? 0 }}</div>
                <div class="stat-label">Overdue</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card d-flex align-items-center gap-3">
            <div class="stat-icon" style="background:#EDE9FE;color:#7C3AED;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div>
                <div class="stat-number">${{ number_format($totalCollected ?? 0, 2) }}</div>
                <div class="stat-label">Total Collected</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Fee Type</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees ?? [] as $fee)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fee->student->first_name ?? 'N/A' }} {{ $fee->student->last_name ?? '' }}</td>
                        <td>{{ $fee->fee_type ?? 'N/A' }}</td>
                        <td>${{ number_format($fee->amount ?? 0, 2) }}</td>
                        <td>{{ $fee->due_date ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $fee->payment_status === 'paid' ? 'badge-success' : ($fee->payment_status === 'overdue' ? 'badge-danger' : 'badge-warning') }}">
                                {{ ucfirst($fee->payment_status ?? 'pending') }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info" title="Print Receipt" onclick="printReceipt(this)" data-student="{{ $fee->student->first_name ?? '' }} {{ $fee->student->last_name ?? '' }}" data-admission="{{ $fee->student->admission_number ?? '' }}" data-type="{{ $fee->fee_type ?? '' }}" data-amount="${{ number_format($fee->amount ?? 0, 2) }}" data-due="{{ $fee->due_date ?? '' }}" data-status="{{ ucfirst($fee->payment_status ?? 'pending') }}" data-method="{{ $fee->payment_method ?? 'N/A' }}" data-date="{{ $fee->paid_date ?? 'N/A' }}" data-txn="{{ $fee->transaction_id ?? 'N/A' }}" data-remark="{{ $fee->remark ?? '' }}"><i class="fas fa-print"></i></button>
                                <a href="{{ route('admin.fees.edit', $fee) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
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

@push('scripts')
<script>
function printReceipt(btn) {
    const data = btn.dataset;
    const win = window.open('', '_blank', 'width=500,height=700,left=100,top=50');
    win.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Payment Receipt</title>
            <style>
                body { font-family: 'Courier New', monospace; padding: 30px; max-width: 450px; margin: 0 auto; font-size: 14px; }
                .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 15px; margin-bottom: 20px; }
                .header h2 { margin: 0; font-size: 24px; letter-spacing: 2px; }
                .header p { margin: 8px 0 0; font-size: 14px; color: #666; }
                .row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dotted #ccc; font-size: 14px; }
                .row .label { color: #666; }
                .row .value { font-weight: bold; text-align: right; }
                .total { text-align: center; font-size: 24px; font-weight: bold; margin: 20px 0; padding: 15px; border: 2px solid #333; }
                .status { text-align: center; padding: 8px; margin: 15px 0; border-radius: 4px; font-weight: bold; font-size: 16px; }
                .status.paid { background: #D1FAE5; color: #065F46; }
                .status.pending { background: #FEF3C7; color: #92400E; }
                .status.overdue { background: #FEE2E2; color: #991B1B; }
                .footer { text-align: center; margin-top: 20px; padding-top: 15px; border-top: 2px dashed #333; font-size: 12px; color: #999; }
                @media print { body { padding: 15px; font-size: 13px; } }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>SCHOOLMS</h2>
                <p>Payment Receipt</p>
            </div>
            <div class="row"><span class="label">Student:</span><span class="value">${data.student}</span></div>
            <div class="row"><span class="label">Admission No:</span><span class="value">${data.admission}</span></div>
            <div class="row"><span class="label">Fee Type:</span><span class="value">${data.type}</span></div>
            <div class="row"><span class="label">Due Date:</span><span class="value">${data.due}</span></div>
            <div class="row"><span class="label">Payment Method:</span><span class="value">${data.method}</span></div>
            <div class="row"><span class="label">Paid Date:</span><span class="value">${data.date}</span></div>
            <div class="row"><span class="label">Transaction ID:</span><span class="value">${data.txn}</span></div>
            ${data.remark ? `<div class="row"><span class="label">Remark:</span><span class="value">${data.remark}</span></div>` : ''}
            <div class="total">AMOUNT: ${data.amount}</div>
            <div class="status ${data.status.toLowerCase()}">STATUS: ${data.status.toUpperCase()}</div>
            <div class="footer">
                <p>Thank you for your payment</p>
                <p>Generated: ${new Date().toLocaleDateString()} ${new Date().toLocaleTimeString()}</p>
            </div>
            <script>window.onload = function() { window.print(); }<\/script>
        </body>
        </html>
    `);
    win.document.close();
}
</script>
@endpush
