@extends('layouts.admin')

@section('title', 'Attendance - SchoolMS Admin')
@section('page_title', 'Attendance Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Track student attendance records</p>
    <a href="{{ route('admin.attendance.mark') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i> Mark Attendance</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceRecords ?? [] as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->student->first_name ?? 'N/A' }} {{ $record->student->last_name ?? '' }}</td>
                        <td>{{ $record->class->class_name ?? 'N/A' }}</td>
                        <td>{{ $record->date ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $record->status === 'present' ? 'badge-success' : ($record->status === 'absent' ? 'badge-danger' : 'badge-warning') }}">
                                {{ ucfirst($record->status ?? 'N/A') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.attendance.edit', $record) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.attendance.destroy', $record) }}" class="d-inline" onsubmit="return confirm('Delete this attendance record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No attendance records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
