<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Reset Password</h2>
        <p>Enter your email and we'll send you a reset link</p>
    </div>
    @endpush

    <div class="auth-form">
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <div class="mb-3" style="font-size: 0.9rem; color: #6b7280;">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="name@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Submit Button -->
            <x-primary-button class="mb-3">
                Send Reset Link
            </x-primary-button>

            <!-- Back to Login -->
            <div class="auth-footer-links">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left me-1"></i>Back to Sign In
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
