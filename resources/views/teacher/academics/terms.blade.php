@extends('layouts.teacher')

@section('title', 'Terms')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Terms</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Academic Year</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terms as $index => $term)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $term->name }}</td>
                            <td>{{ $term->academicYear->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($term->start_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($term->end_date)->format('M d, Y') }}</td>
                            <td>
                                @if ($term->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No terms found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
