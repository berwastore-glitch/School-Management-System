@extends('layouts.admin')

@section('title', 'Subjects')
@section('page_title', 'Subjects')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search subjects..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('admin.subjects') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Add Subject</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Subject Name</th>
                        <th>Teachers & Classes</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="badge bg-secondary">{{ $subject->code }}</span></td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>
                            @php
                                $classMap = \App\Models\SchoolClass::whereIn('id', $subject->teachers->pluck('pivot.class_id'))->get()->keyBy('id');
                            @endphp
                            @forelse($subject->teachers as $teacher)
                                @php $cls = $classMap[$teacher->pivot->class_id] ?? null; @endphp
                                <span class="badge bg-primary mb-1">
                                    {{ $teacher->first_name }} {{ $teacher->last_name }} — {{ $cls->class_name ?? 'N/A' }} {{ $cls->section ?? '' }}
                                </span>
                            @empty
                                <span class="text-muted">No teachers assigned</span>
                            @endforelse
                        </td>
                        <td>
                            <span class="badge bg-{{ $subject->status ? 'success' : 'danger' }}">
                                {{ $subject->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No subjects found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $subjects->links() }}</div>
@endsection
