@extends('layouts.admin')

@section('title', 'Curriculum Management')
@section('page_title', 'Curriculums')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search curriculums..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            @if(request('search'))<a href="{{ route('admin.curriculums') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
        </form>
    </div>
    <a href="{{ route('admin.curriculums.create') }}" class="btn btn-orange"><i class="fas fa-plus me-1"></i>Add Curriculum</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($curriculums as $curriculum)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $curriculum->name }}</td>
                        <td><span class="badge bg-secondary">{{ $curriculum->code }}</span></td>
                        <td>
                            <span class="badge bg-{{ $curriculum->is_active ? 'success' : 'danger' }}">
                                {{ $curriculum->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.curriculums.edit', $curriculum) }}" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.curriculums.destroy', $curriculum) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this curriculum?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">No curriculums found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-3">{{ $curriculums->links() }}</div>
@endsection
