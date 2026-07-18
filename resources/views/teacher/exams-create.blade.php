@extends('layouts.teacher')

@section('title', 'Create Exam')
@section('page_title', 'Create New Exam')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Fill in the details to create a new exam</p>
    <a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('teacher.exams.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Exam Name <span class="text-danger">*</span></label>
                    <input type="text" name="exam_name" class="form-control" value="{{ old('exam_name') }}" required placeholder="e.g. Mid Term Exam">
                    @error('exam_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->subject_name }} ({{ $subject->code }})</option>
                        @endforeach
                    </select>
                    @error('subject_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Marks <span class="text-danger">*</span></label>
                    <input type="number" name="total_marks" class="form-control" value="{{ old('total_marks', 100) }}" min="1" required>
                    @error('total_marks') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Passing Marks <span class="text-danger">*</span></label>
                    <input type="number" name="passing_marks" class="form-control" value="{{ old('passing_marks', 40) }}" min="1" required>
                    @error('passing_marks') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Optional description">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Create Exam</button>
                <a href="{{ route('teacher.students') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
