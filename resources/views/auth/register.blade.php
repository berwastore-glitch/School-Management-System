<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Create Account</h2>
        <p>Get started with your school management system</p>
    </div>
    @endpush

    <div class="auth-form">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- I am a -->
            <div class="mb-3">
                <label class="form-label fw-semibold">I am a</label>
                <select name="role" class="form-select" required>
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
            </div>

            <!-- School -->
            <div class="mb-3">
                <label class="form-label fw-semibold">School <span class="text-danger">*</span></label>
                <select name="school_id" class="form-select" required>
                    <option value="">Select your school</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Name -->
            <div class="mb-3">
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-select" required>
                    <option value="">Select gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- Date of Birth -->
            <div class="mb-3">
                <x-input-label for="date_of_birth" value="Date of Birth" />
                <x-text-input id="date_of_birth" class="form-control" type="date" name="date_of_birth" :value="old('date_of_birth')" required />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-1" />
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Create a strong password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Submit Button -->
            <x-primary-button class="mb-3">
                Create Account
            </x-primary-button>

            <!-- Login Link -->
            <div class="auth-footer-links">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </div>
        </form>
    </div>
</x-guest-layout>
