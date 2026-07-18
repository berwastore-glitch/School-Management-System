@extends('layouts.admin')

@section('title', 'Edit Grade Level')
@section('page_title', 'Edit Grade Level')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Update grade level details</p>
    <a href="{{ route('admin.grade-levels') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.grade-levels.update', $gradeLevel) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Grade Level Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $gradeLevel->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Curriculum <span class="text-danger">*</span></label>
                    <select name="curriculum_id" class="form-select" required>
                        <option value="">Select Curriculum</option>
                        @foreach($curriculums as $curriculum)
                            <option value="{{ $curriculum->id }}" {{ old('curriculum_id', $gradeLevel->curriculum_id) == $curriculum->id ? 'selected' : '' }}>{{ $curriculum->name }}</option>
                        @endforeach
                    </select>
                    @error('curriculum_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sort Order <span class="text-danger">*</span></label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $gradeLevel->sort_order) }}" required min="0">
                    @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="is_active" class="form-select" required>
                        <option value="1" {{ old('is_active', $gradeLevel->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $gradeLevel->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update Grade Level</button>
                <a href="{{ route('admin.grade-levels') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
