@extends('layouts.admin')

@section('title', 'Edit Subject')
@section('page_title', 'Edit Subject')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Update subject details and teacher assignments</p>
    <a href="{{ route('admin.subjects') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject Name <span class="text-danger">*</span></label>
                    <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name', $subject->subject_name) }}" required>
                    @error('subject_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $subject->code) }}" required>
                    @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $subject->description) }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status', $subject->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $subject->status) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-chalkboard-teacher me-1"></i>Assign Teachers to Classes <span class="text-muted fw-normal">(Optional)</span></h6>

            <div id="teacherAssignments">
                @forelse($subject->teachers as $i => $t)
                <div class="row g-2 mb-2 teacher-row">
                    <div class="col-md-5">
                        <select name="teachers[{{ $i }}][teacher_id]" class="form-select">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $tch)
                                <option value="{{ $tch->id }}" {{ $t->id == $tch->id ? 'selected' : '' }}>{{ $tch->first_name }} {{ $tch->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="teachers[{{ $i }}][class_id]" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($classes as $cls)
                                <option value="{{ $cls->id }}" {{ $t->pivot->class_id == $cls->id ? 'selected' : '' }}>{{ $cls->class_name }} {{ $cls->section ? '- ' . $cls->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row w-100"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @empty
                <div class="row g-2 mb-2 teacher-row">
                    <div class="col-md-5">
                        <select name="teachers[0][teacher_id]" class="form-select">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $tch)
                                <option value="{{ $tch->id }}">{{ $tch->first_name }} {{ $tch->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="teachers[0][class_id]" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($classes as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->class_name }} {{ $cls->section ? '- ' . $cls->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row w-100" style="display:none"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @endforelse
            </div>

            <button type="button" id="addTeacher" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus me-1"></i>Add Teacher Assignment</button>

            <div class="mt-3">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Update Subject</button>
                <a href="{{ route('admin.subjects') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let teacherIndex = {{ count($subject->teachers) ?: 1 }};
const teachers = @json($teachers);
const classes = @json($classes);

document.getElementById('addTeacher').addEventListener('click', function() {
    const container = document.getElementById('teacherAssignments');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 teacher-row';

    let teacherOpts = '<option value="">Select Teacher</option>';
    teachers.forEach(t => { teacherOpts += `<option value="${t.id}">${t.first_name} ${t.last_name}</option>`; });

    let classOpts = '<option value="">Select Class</option>';
    classes.forEach(c => { classOpts += `<option value="${c.id}">${c.class_name} ${c.section ? '- ' + c.section : ''}</option>`; });

    row.innerHTML = `
        <div class="col-md-5"><select name="teachers[${teacherIndex}][teacher_id]" class="form-select">${teacherOpts}</select></div>
        <div class="col-md-5"><select name="teachers[${teacherIndex}][class_id]" class="form-select">${classOpts}</select></div>
        <div class="col-md-2"><button type="button" class="btn btn-danger btn-sm remove-row w-100"><i class="fas fa-times"></i></button></div>
    `;
    container.appendChild(row);
    teacherIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) e.target.closest('.teacher-row').remove();
});
</script>
@endpush
@endsection
