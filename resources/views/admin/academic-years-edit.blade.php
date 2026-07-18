@extends('layouts.admin')

@section('title', 'Edit Academic Year')
@section('page_title', 'Edit Academic Year')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Update academic year details</p>
    <a href="{{ route('admin.academic-years') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.academic-years.update', $academicYear) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Academic Year Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $academicYear->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="is_active" class="form-select" required>
                        <option value="1" {{ old('is_active', $academicYear->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $academicYear->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $academicYear->start_date ? \Carbon\Carbon::parse($academicYear->start_date)->format('Y-m-d') : '') }}" required>
                    @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $academicYear->end_date ? \Carbon\Carbon::parse($academicYear->end_date)->format('Y-m-d') : '') }}" required>
                    @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_current" value="1" id="isCurrent" {{ old('is_current', $academicYear->is_current) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isCurrent">Set as Current Academic Year</label>
                    </div>
                    @error('is_current') <small class="text-danger d-block">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update Academic Year</button>
                <a href="{{ route('admin.academic-years') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
