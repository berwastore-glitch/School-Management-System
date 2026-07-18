@extends('layouts.teacher')

@section('title', 'Attendance')
@section('page_title', 'Attendance')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <select name="class_id" class="form-select" style="width:auto">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class_name }} {{ $class->section }}</option>
                @endforeach
            </select>
            <input type="date" name="date" class="form-control" style="width:auto" value="{{ request('date') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i></button>
            @if(request('class_id') || request('date'))<a href="{{ route('teacher.attendance') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('teacher.attendance.mark') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Mark Attendance</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>Remark</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceRecords as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->date ? \Carbon\Carbon::parse($record->date)->format('M d, Y') : 'N/A' }}</td>
                        <td>{{ $record->student->first_name ?? 'N/A' }} {{ $record->student->last_name ?? '' }}</td>
                        <td>{{ $record->class->class_name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $badge = match($record->status) {
                                    'present' => 'success',
                                    'absent' => 'danger',
                                    'late' => 'warning',
                                    'excused' => 'info',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($record->status) }}</span>
                        </td>
                        <td>{{ $record->remark ?? '-' }}</td>
                        <td>
                            <a href="{{ route('teacher.attendance.edit', $record) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('teacher.attendance.destroy', $record) }}" class="d-inline" onsubmit="return confirm('Delete this attendance record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No attendance records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $attendanceRecords->links() }}</div>
@endsection
