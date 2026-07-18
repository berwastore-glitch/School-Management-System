@php
    $isAdmin = auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin';
    $isTeacher = auth()->user()->role === 'teacher';
    $layout = $isAdmin ? 'layouts.admin' : 'layouts.teacher';
    $backRoute = $isAdmin ? 'admin.attendance' : 'teacher.attendance';
    $updateRoute = $isAdmin ? 'admin.attendance.update' : 'teacher.attendance.update';
@endphp

@extends($layout)

@section('title', 'Edit Attendance - SchoolMS')
@section('page_title', 'Edit Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Update attendance record</p>
    <a href="{{ route($backRoute) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Attendance</a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route($updateRoute, $attendance) }}">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Student <span class="text-danger">*</span></label>
                    <select name="student_id" id="studentSelect" class="form-select" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $attendance->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                    <select name="class_id" id="classSelect" class="form-select" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $attendance->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} {{ $class->section ? '- ' . $class->section : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ $attendance->date }}" required>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                        <option value="excused" {{ $attendance->status === 'excused' ? 'selected' : '' }}>Excused</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Remark</label>
                    <input type="text" name="remark" class="form-control" value="{{ $attendance->remark }}" placeholder="Optional remark">
                </div>
            </div>

            <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i> Update Attendance</button>
        </form>
    </div>
</div>
@endsection
