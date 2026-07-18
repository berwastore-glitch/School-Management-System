@extends('layouts.admin')

@section('title', 'Add Class - SchoolMS Admin')
@section('page_title', 'Add New Class')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Fill in the details to add a new class</p>
    <a href="{{ route('admin.classes') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Classes</a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.classes.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class Name <span class="text-danger">*</span></label>
                    <input type="text" name="class_name" class="form-control" value="{{ old('class_name') }}" required placeholder="e.g. Grade 10">
                    @error('class_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Section</label>
                    <input type="text" name="section" class="form-control" value="{{ old('section') }}" placeholder="e.g. A">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Capacity <span class="text-danger">*</span></label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', 40) }}" required min="1" placeholder="Max students">
                    @error('capacity') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Class Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Curriculum</label>
                    <select name="curriculum_id" class="form-select">
                        <option value="">Select Curriculum</option>
                        @foreach($curriculums as $curriculum)
                            <option value="{{ $curriculum->id }}" {{ old('curriculum_id') == $curriculum->id ? 'selected' : '' }}>{{ $curriculum->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Grade Level</label>
                    <select name="grade_level_id" class="form-select">
                        <option value="">Select Grade Level</option>
                        @foreach($gradeLevels as $gradeLevel)
                            <option value="{{ $gradeLevel->id }}" {{ old('grade_level_id') == $gradeLevel->id ? 'selected' : '' }}>{{ $gradeLevel->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i> Save Class</button>
                <a href="{{ route('admin.classes') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
