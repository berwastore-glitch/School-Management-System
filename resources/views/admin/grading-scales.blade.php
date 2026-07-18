@extends('layouts.admin')

@section('title', 'Grading Scales')
@section('page_title', 'Grading Scales')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Search grades..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    @if(request('search'))<a href="{{ route('admin.grading-scales') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>@endif
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Curriculum</th>
                                <th>Grade</th>
                                <th>Range</th>
                                <th>Points</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gradingScales as $scale)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-info">{{ $scale->curriculum->name ?? 'N/A' }}</span></td>
                                <td><strong>{{ $scale->grade_letter }}</strong></td>
                                <td>{{ $scale->min_percentage }}% - {{ $scale->max_percentage }}%</td>
                                <td>{{ $scale->grade_points ?? '-' }}</td>
                                <td>{{ $scale->description ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('admin.grading-scales.destroy', $scale) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this grade?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-4 text-muted">No grading scales found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">{{ $gradingScales->links() }}</div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header fw-semibold">Add Grading Scale</div>
            <div class="card-body">
                <form action="{{ route('admin.grading-scales.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Curriculum <span class="text-danger">*</span></label>
                        <select name="curriculum_id" class="form-select" required>
                            <option value="">Select Curriculum</option>
                            @foreach($curriculums as $c)
                                <option value="{{ $c->id }}" {{ old('curriculum_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('curriculum_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grade Letter <span class="text-danger">*</span></label>
                        <input type="text" name="grade_letter" class="form-control" value="{{ old('grade_letter') }}" placeholder="e.g. A+" required>
                        @error('grade_letter')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Min % <span class="text-danger">*</span></label>
                            <input type="number" name="min_percentage" class="form-control" value="{{ old('min_percentage', 0) }}" min="0" max="100" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Max % <span class="text-danger">*</span></label>
                            <input type="number" name="max_percentage" class="form-control" value="{{ old('max_percentage', 100) }}" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Grade Points</label>
                        <input type="number" name="grade_points" class="form-control" value="{{ old('grade_points') }}" min="0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="e.g. Excellent">
                    </div>
                    <button type="submit" class="btn btn-orange w-100"><i class="fas fa-plus me-1"></i>Add Grade</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
