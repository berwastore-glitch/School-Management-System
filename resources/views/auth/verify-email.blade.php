<x-guest-layout>
    @push('auth_content')
    <div class="auth-form-header">
        <h2>Verify Email</h2>
        <p>Check your inbox to verify your account</p>
    </div>
    @endpush

    <div class="auth-form">
        <div class="mb-3" style="font-size: 0.9rem; color: #6b7280;">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert-success-custom">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>
                    Resend Verification Email
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="auth-link border-0 bg-transparent p-0">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
