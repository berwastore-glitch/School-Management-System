<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Confirm Password</h2>
        <p>This is a secure area. Please confirm your password.</p>
    </div>
    @endpush

    <div class="auth-form">
        <div class="mb-3" style="font-size: 0.9rem; color: #6b7280;">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Submit Button -->
            <x-primary-button>
                Confirm
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
