@extends('layouts.admin')

@section('title', 'School Settings')
@section('page_title', 'School Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-semibold"><i class="fas fa-school me-2"></i>School Information</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('school.settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">School Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}" required placeholder="e.g. Sunrise Academy">
                                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $school->email) }}" placeholder="info@yourschool.com">
                                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $school->phone) }}" placeholder="+256 700 000 000">
                                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Full school address">{{ old('address', $school->address) }}</textarea>
                                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">School Logo</label>
                            <div class="text-center mb-3">
                                @if($school->logo)
                                    <img src="{{ asset('storage/' . $school->logo) }}" alt="School Logo" class="img-fluid rounded border" style="max-height: 120px;">
                                @else
                                    <div class="border rounded d-flex align-items-center justify-content-center bg-light" style="height: 120px;">
                                        <div>
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                            <p class="text-muted small mb-0 mt-1">No logo</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                            <small class="text-muted">PNG, JPG up to 2MB</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Slug: <code>{{ $school->slug }}</code> &middot;
                            Created: {{ $school->created_at->format('M d, Y') }}
                        </div>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
