@extends('layouts.admin')

@section('title', 'Edit Curriculum')
@section('page_title', 'Edit Curriculum')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Update curriculum details</p>
    <a href="{{ route('admin.curriculums') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.curriculums.update', $curriculum) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Curriculum Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $curriculum->name) }}" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Curriculum Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $curriculum->code) }}" required>
                    @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $curriculum->description) }}</textarea>
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="is_active" class="form-select" required>
                        <option value="1" {{ old('is_active', $curriculum->is_active) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $curriculum->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update Curriculum</button>
                <a href="{{ route('admin.curriculums') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
