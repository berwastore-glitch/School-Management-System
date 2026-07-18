@extends('layouts.admin')

@section('title', 'Terms')
@section('page_title', 'Terms')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search terms..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('admin.terms') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('admin.terms.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Add Term</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Current</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($terms as $term)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $term->name }}</td>
                        <td><span class="badge bg-primary">{{ $term->academicYear->name ?? 'N/A' }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($term->start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($term->end_date)->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $term->is_current ? 'success' : 'secondary' }}">
                                {{ $term->is_current ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $term->is_active ? 'success' : 'danger' }}">
                                {{ $term->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.terms.edit', $term) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.terms.destroy', $term) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this term?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-4 text-muted">No terms found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $terms->links() }}</div>
@endsection
