@extends('layouts.student')

@section('title', 'No Record - SchoolMS')
@section('page_title', 'No Record')

@section('content')
<div class="card">
    <div class="card-body text-center py-5">
        <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size:3rem;"></i>
        <h4 class="text-muted">No Student Record Found</h4>
        <p class="text-muted mb-4">Your account does not have an associated student record. Please contact your administrator.</p>
        <a href="{{ route('student.dashboard') }}" class="btn btn-orange">
            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection
