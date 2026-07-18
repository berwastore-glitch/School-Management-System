<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Reset Password</h2>
        <p>Enter your new password below</p>
    </div>
    @endpush

    <div class="auth-form">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-3">
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="name@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" value="New Password" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter new password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm new password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <!-- Submit Button -->
            <x-primary-button>
                Reset Password
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
