<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Select School - SchoolMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #0A2342; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .select-card { background: white; border-radius: 16px; padding: 40px; max-width: 500px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .school-option { border: 2px solid #E5E7EB; border-radius: 12px; padding: 16px 20px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 15px; }
        .school-option:hover { border-color: #D97706; background: #FFFBEB; }
        .school-option.selected { border-color: #D97706; background: #FEF3C7; }
        .school-icon { width: 48px; height: 48px; border-radius: 12px; background: #0A2342; color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
        .btn-orange { background: #D97706; color: white; border: none; border-radius: 8px; padding: 12px 30px; font-weight: 600; }
        .btn-orange:hover { background: #B85D00; color: white; }
        .btn-orange:disabled { background: #9CA3AF; cursor: not-allowed; }
        .btn-outline-orange { background: transparent; color: #D97706; border: 2px solid #D97706; border-radius: 8px; padding: 12px 30px; font-weight: 600; }
        .btn-outline-orange:hover { background: #D97706; color: white; }
    </style>
</head>
<body>
    <div class="select-card">
        <div class="text-center mb-4">
            <div class="mb-3">
                <i class="fas fa-graduation-cap text-primary" style="font-size: 3rem;"></i>
            </div>
            <h4 class="fw-bold" style="color: #0A2342;">Select School</h4>
            <p class="text-muted">Choose which school you want to manage</p>
        </div>

        @if($schools->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                No schools found. Create your first school to get started.
            </div>
            <button type="button" class="btn btn-orange w-100 mb-3" data-bs-toggle="modal" data-bs-target="#createSchoolModal">
                <i class="fas fa-plus me-2"></i>Create School
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100">Skip for now</a>
        @else
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-outline-orange btn-sm" data-bs-toggle="modal" data-bs-target="#createSchoolModal">
                    <i class="fas fa-plus me-1"></i>Add School
                </button>
            </div>
            <form method="POST" action="{{ route('school.select.store') }}" id="schoolForm">
                @csrf
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($schools as $school)
                        <label class="school-option" onclick="selectSchool({{ $school->id }})">
                            <input type="radio" name="school_id" value="{{ $school->id }}" class="d-none" {{ session('school_id') == $school->id ? 'checked' : '' }}>
                            <div class="school-icon">
                                <i class="fas fa-school"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $school->name }}</div>
                                <small class="text-muted">{{ $school->email ?? 'No email' }}</small>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('school_id')<div class="text-danger small mb-3">{{ $message }}</div>@enderror
                <button type="submit" class="btn btn-orange w-100" id="submitBtn" disabled>
                    <i class="fas fa-arrow-right me-1"></i>Continue to Dashboard
                </button>
            </form>
        @endif

        <div class="text-center mt-3">
            <a href="{{ route('logout') }}" class="text-muted small text-decoration-none" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
            <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
        </div>
    </div>

    <!-- Create School Modal -->
    <div class="modal fade" id="createSchoolModal" tabindex="-1" aria-labelledby="createSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: #0A2342; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold" id="createSchoolModalLabel">
                        <i class="fas fa-school me-2"></i>Create New School
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('school.create') }}">
                    @csrf
                    <div class="modal-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="school_name" class="form-label fw-semibold">School Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="school_name" name="name" value="{{ old('name') }}" placeholder="e.g. Kigali International School" required>
                        </div>
                        <div class="mb-3">
                            <label for="school_email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="school_email" name="email" value="{{ old('email') }}" placeholder="info@school.edu">
                        </div>
                        <div class="mb-3">
                            <label for="school_phone" class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control" id="school_phone" name="phone" value="{{ old('phone') }}" placeholder="+250 700 000 000">
                        </div>
                        <div class="mb-3">
                            <label for="school_address" class="form-label fw-semibold">Address</label>
                            <textarea class="form-control" id="school_address" name="address" rows="2" placeholder="Street, City, Country">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-orange">
                            <i class="fas fa-plus me-1"></i>Create School
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function selectSchool(id) {
            document.querySelectorAll('.school-option').forEach(el => el.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById('submitBtn').disabled = false;
        }

        @if($errors->any())
            var modal = new bootstrap.Modal(document.getElementById('createSchoolModal'));
            modal.show();
        @endif
    </script>
</body>
</html>
