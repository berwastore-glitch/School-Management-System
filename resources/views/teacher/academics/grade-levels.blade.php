@extends('layouts.teacher')

@section('title', 'Grade Levels')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Grade Levels</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Sort Order</th>
                        <th>Curriculum</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($gradeLevels as $index => $gradeLevel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $gradeLevel->name }}</td>
                            <td>{{ $gradeLevel->code }}</td>
                            <td>{{ $gradeLevel->sort_order }}</td>
                            <td>{{ $gradeLevel->curriculum->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No grade levels found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
