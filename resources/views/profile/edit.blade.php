@php
    $isAdmin = auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin';
    $isTeacher = auth()->user()->role === 'teacher';
    $isStudent = auth()->user()->role === 'student';
    $layout = $isAdmin ? 'layouts.admin' : ($isStudent ? 'layouts.student' : 'layouts.teacher');
    $route = $isAdmin ? 'admin.dashboard' : ($isStudent ? 'student.dashboard' : 'teacher.dashboard');
    $teacher = auth()->user()->teacher;
@endphp

@extends($layout)

@section('title', 'My Profile - SchoolMS')
@section('page_title', 'My Profile')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;border:4px solid #D97706;">
                    @else
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width:120px;height:120px;">
                            <i class="fas fa-user text-primary" style="font-size:3rem;"></i>
                        </div>
                    @endif
                </div>
                <h5 class="fw-bold mb-1">{{ auth()->user()->name }}</h5>
                <span class="badge bg-{{ $isAdmin ? 'primary' : 'warning text-dark' }} px-3 py-2 mb-2">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                @if($teacher && $teacher->phone)
                    <p class="text-muted small mt-1"><i class="fas fa-phone me-1"></i>{{ $teacher->phone }}</p>
                @endif
                @if($teacher)
                    <hr class="my-3">
                    <div class="text-start px-3">
                        @if($teacher->employee_id)
                            <p class="small mb-1"><i class="fas fa-id-badge me-2 text-muted"></i><strong>{{ $teacher->employee_id }}</strong></p>
                        @endif
                        @if($teacher->gender)
                            <p class="small mb-1"><i class="fas fa-venus-mars me-2 text-muted"></i>{{ $teacher->gender }}</p>
                        @endif
                        @if($teacher->subject)
                            <p class="small mb-1"><i class="fas fa-book me-2 text-muted"></i>{{ $teacher->subject }}</p>
                        @endif
                        @if($teacher->qualification)
                            <p class="small mb-1"><i class="fas fa-graduation-cap me-2 text-muted"></i>{{ $teacher->qualification }}</p>
                        @endif
                        @if($teacher->date_of_birth)
                            <p class="small mb-1"><i class="fas fa-calendar me-2 text-muted"></i>{{ \Carbon\Carbon::parse($teacher->date_of_birth)->format('M d, Y') }}</p>
                        @endif
                        @if($teacher->address)
                            <p class="small mb-0"><i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $teacher->address }}</p>
                        @endif
                    </div>
                @endif
                @if($isStudent && auth()->user()->student)
                    @php $student = auth()->user()->student; @endphp
                    <hr class="my-3">
                    <div class="text-start px-3">
                        @if($student->admission_number)
                            <p class="small mb-1"><i class="fas fa-id-badge me-2 text-muted"></i><strong>{{ $student->admission_number }}</strong></p>
                        @endif
                        @if($student->gender)
                            <p class="small mb-1"><i class="fas fa-venus-mars me-2 text-muted"></i>{{ $student->gender }}</p>
                        @endif
                        @if($student->date_of_birth)
                            <p class="small mb-1"><i class="fas fa-calendar me-2 text-muted"></i>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') }}</p>
                        @endif
                        @if($student->phone)
                            <p class="small mb-0"><i class="fas fa-phone me-2 text-muted"></i>{{ $student->phone }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header"><i class="fas fa-user-edit me-2"></i>Edit Profile</div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                        @error('profile_picture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="mt-2">
                            <img id="imagePreview" src="#" alt="Preview" style="display:none;max-height:100px;border-radius:8px;">
                        </div>
                    </div>

                    @if($isTeacher && $teacher)
                        <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size:0.75rem;letter-spacing:1px;">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">First Name</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $teacher->first_name) }}">
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Last Name</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $teacher->last_name) }}">
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select gender</option>
                                    <option value="Male" {{ old('gender', $teacher->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $teacher->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $teacher->phone) }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $teacher->date_of_birth) }}">
                                @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Employee ID</label>
                                <input type="text" class="form-control" value="{{ $teacher->employee_id }}" disabled>
                                <small class="text-muted">Cannot be changed</small>
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted text-uppercase mb-3 mt-2" style="font-size:0.75rem;letter-spacing:1px;">Professional Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Subject</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject', $teacher->subject) }}">
                                @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Qualification</label>
                                <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $teacher->qualification) }}">
                                @error('qualification') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $teacher->address) }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <h6 class="fw-bold text-muted text-uppercase mb-3 mt-2" style="font-size:0.75rem;letter-spacing:1px;">Account</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Display Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    @else
                        @php $student = auth()->user()->student; @endphp
                        <h6 class="fw-bold text-muted text-uppercase mb-3" style="font-size:0.75rem;letter-spacing:1px;">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Full Name *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select gender</option>
                                    <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
                                @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone ?? '') }}">
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-orange"><i class="fas fa-save me-1"></i>Save Changes</button>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header"><i class="fas fa-lock me-2"></i>Change Password</div>
            <div class="card-body">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Current Password *</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">New Password *</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fas fa-key me-1"></i>Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
