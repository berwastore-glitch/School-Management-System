@extends('layouts.admin')

@section('title', 'Mark Attendance - SchoolMS Admin')
@section('page_title', 'Mark Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Select a class and date, then mark each student's attendance</p>
    <a href="{{ route('admin.attendance') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Attendance</a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.attendance.store') }}" id="attendanceForm">
            @csrf
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                    <select name="class_id" id="classSelect" class="form-select" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }} {{ $class->section ? '- ' . $class->section : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="attendanceDate" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="button" id="loadStudents" class="btn btn-orange"><i class="fas fa-search me-1"></i> Load Students</button>
                </div>
            </div>

            <div id="studentsContainer" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Students</h6>
                    <button type="button" id="markAllPresent" class="btn btn-sm btn-outline-success">Mark All Present</button>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Admission No.</th>
                                <th>Status</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody">
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i> Save Attendance</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('loadStudents').addEventListener('click', function() {
    const classId = document.getElementById('classSelect').value;
    if (!classId) {
        alert('Please select a class first');
        return;
    }

    fetch('{{ url("admin/api/students-by-class") }}/' + classId)
        .then(response => response.json())
        .then(students => {
            const tbody = document.getElementById('studentsTableBody');
            tbody.innerHTML = '';

            if (students.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-muted">No students found in this class</td></tr>';
                document.getElementById('studentsContainer').style.display = 'block';
                return;
            }

            students.forEach((student, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${student.first_name} ${student.last_name}</td>
                    <td>${student.admission_number}</td>
                    <td>
                        <select name="students[${student.id}][status]" class="form-select form-select-sm" style="width: 140px;">
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Late</option>
                            <option value="excused">Excused</option>
                        </select>
                    </td>
                    <td><input type="text" name="students[${student.id}][remark]" class="form-control form-control-sm" placeholder="Optional" style="width: 160px;"></td>
                `;
                tbody.appendChild(row);
            });

            document.getElementById('studentsContainer').style.display = 'block';
        })
        .catch(error => {
            alert('Error loading students. Please try again.');
            console.error(error);
        });
});

document.getElementById('markAllPresent').addEventListener('click', function() {
    document.querySelectorAll('#studentsTableBody select').forEach(select => {
        select.value = 'present';
    });
});
</script>
@endpush
