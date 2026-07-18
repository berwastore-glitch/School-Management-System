@extends('layouts.admin')

@section('title', 'Add Teacher - SchoolMS Admin')
@section('page_title', 'Add New Teacher')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted">Fill in the details to add a new teacher</p>
    <a href="{{ route('admin.teachers') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Teachers</a>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.teachers.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required placeholder="Enter first name">
                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required placeholder="Enter last name">
                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="teacher@email.com">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Min 8 characters">
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="e.g. Mathematics">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}" placeholder="e.g. M.Sc, B.Ed">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone number">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Home address">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i> Save Teacher</button>
                <a href="{{ route('admin.teachers') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
