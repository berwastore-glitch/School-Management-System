@extends('layouts.admin')

@section('title', 'Edit Class')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3"><i class="fas fa-edit me-2"></i>Edit Class</h1>
    <a href="{{ route('admin.classes') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.classes.update', $class) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class Name *</label>
                    <input type="text" name="class_name" class="form-control @error('class_name') is-invalid @enderror" value="{{ old('class_name', $class->class_name) }}" required>
                    @error('class_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" class="form-control" value="{{ old('section', $class->section) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Capacity *</label>
                    <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $class->capacity) }}" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Curriculum</label>
                    <select name="curriculum_id" class="form-select">
                        <option value="">Select Curriculum</option>
                        @foreach($curriculums as $curriculum)
                            <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $class->curriculum_id) == $curriculum->id ? 'selected' : '' }}>{{ $curriculum->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Grade Level</label>
                    <select name="grade_level_id" class="form-select">
                        <option value="">Select Grade Level</option>
                        @foreach($gradeLevels as $gradeLevel)
                            <option value="{{ $gradeLevel->id }}" {{ old('grade_level_id', $class->grade_level_id) == $gradeLevel->id ? 'selected' : '' }}>{{ $gradeLevel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status', $class->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $class->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update Class</button>
                <a href="{{ route('admin.classes') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
