@extends('layouts.admin')

@section('title', 'Academic Years')
@section('page_title', 'Academic Years')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search academic years..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('admin.academic-years') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('admin.academic-years.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Add Academic Year</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Current</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($academicYears as $year)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $year->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($year->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($year->end_date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $year->is_current ? 'success' : 'secondary' }}">
                                {{ $year->is_current ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $year->is_active ? 'success' : 'danger' }}">
                                {{ $year->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.academic-years.edit', $year) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.academic-years.destroy', $year) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this academic year?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">No academic years found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $academicYears->links() }}</div>
@endsection
