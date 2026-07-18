<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Welcome Back</h2>
        <p>Sign in to your account to continue</p>
    </div>
    @endpush

    <div class="auth-form">
        <!-- Session Status -->
        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <x-primary-button class="mb-3">
                Sign In
            </x-primary-button>

            <!-- Register Link -->
            <div class="auth-footer-links">
                Don't have an account?
                <a href="{{ route('register') }}">Create one</a>
            </div>
        </form>
    </div>
</x-guest-layout>
