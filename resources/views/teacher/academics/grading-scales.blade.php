@extends('layouts.teacher')

@section('title', 'Grading Scales')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Grading Scales</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Min %</th>
                        <th>Max %</th>
                        <th>Points</th>
                        <th>Description</th>
                        <th>Curriculum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gradingScales as $index => $scale)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="badge bg-primary">{{ $scale->grade_letter }}</span></td>
                            <td>{{ $scale->min_percentage }}%</td>
                            <td>{{ $scale->max_percentage }}%</td>
                            <td>{{ $scale->grade_points }}</td>
                            <td>{{ $scale->description ?? '-' }}</td>
                            <td>{{ $scale->curriculum->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No grading scales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
