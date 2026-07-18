@extends('layouts.admin')

@section('title', 'Edit Payment')
@section('page_title', 'Edit Payment')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Update fee payment details</p>
    <a href="{{ route('admin.fees') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.fees.update', $fee) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <select name="student_id" class="form-select" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $fee->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Fee Type <span class="text-danger">*</span></label>
                    <input type="text" name="fee_type" class="form-control" value="{{ old('fee_type', $fee->fee_type) }}" required placeholder="e.g. Tuition Fee">
                    @error('fee_type') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount', $fee->amount) }}" min="0" step="0.01" required>
                    @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Due Date <span class="text-danger">*</span></label>
                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $fee->due_date) }}" required>
                    @error('due_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" class="form-select" required>
                        <option value="pending" {{ old('payment_status', $fee->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('payment_status', $fee->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ old('payment_status', $fee->payment_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Paid Date</label>
                    <input type="date" name="paid_date" class="form-control" value="{{ old('paid_date', $fee->paid_date) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="">Select Method</option>
                        <option value="cash" {{ old('payment_method', $fee->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank_transfer" {{ old('payment_method', $fee->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="card" {{ old('payment_method', $fee->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="online" {{ old('payment_method', $fee->payment_method) == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Transaction ID</label>
                    <input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $fee->transaction_id) }}" placeholder="Optional">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Remark</label>
                    <textarea name="remark" class="form-control" rows="2" placeholder="Optional notes">{{ old('remark', $fee->remark) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update Payment</button>
                <a href="{{ route('admin.fees') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
