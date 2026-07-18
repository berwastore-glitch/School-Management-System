@extends('layouts.teacher')

@section('title', 'Add Subject')
@section('page_title', 'Add New Subject')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Fill in the details to add a new subject</p>
    <a href="{{ route('teacher.subjects') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i>Back</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('teacher.subjects.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject Name <span class="text-danger">*</span></label>
                    <input type="text" name="subject_name" class="form-control" value="{{ old('subject_name') }}" required placeholder="e.g. Mathematics">
                    @error('subject_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" required placeholder="e.g. MATH101">
                    @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Optional description">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ old('status', 1) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <hr class="my-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-chalkboard-teacher me-1"></i>Assign Teachers to Classes <span class="text-muted fw-normal">(Optional)</span></h6>
            <p class="text-muted small">You can assign teachers later. Leave blank if not needed yet.</p>

            <div id="teacherAssignments">
                <div class="row g-2 mb-2 teacher-row">
                    <div class="col-md-5">
                        <select name="teachers[0][teacher_id]" class="form-select">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}">{{ $t->first_name }} {{ $t->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="teachers[0][class_id]" class="form-select">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }} {{ $class->section ? '- ' . $class->section : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-row w-100" style="display:none"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <button type="button" id="addTeacher" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus me-1"></i>Add Teacher Assignment</button>

            <div class="mt-3">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Save Subject</button>
                <a href="{{ route('teacher.subjects') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let teacherIndex = 1;
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
        <div class="col-md-5">
            <select name="teachers[${teacherIndex}][teacher_id]" class="form-select">${teacherOpts}</select>
        </div>
        <div class="col-md-5">
            <select name="teachers[${teacherIndex}][class_id]" class="form-select">${classOpts}</select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-row w-100"><i class="fas fa-times"></i></button>
        </div>
    `;
    container.appendChild(row);
    teacherIndex++;
    updateRemoveButtons();
});

document.addEventListener('click', function(e) {
    if (e.target.closest('.remove-row')) {
        e.target.closest('.teacher-row').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.teacher-row');
    rows.forEach((row, i) => {
        const btn = row.querySelector('.remove-row');
        if (btn) btn.style.display = rows.length > 1 ? 'block' : 'none';
    });
}
</script>
@endpush
@endsection
