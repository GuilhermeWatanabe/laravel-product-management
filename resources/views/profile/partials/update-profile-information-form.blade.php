<section>
    <header>
        <h2 class="h5 text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-secondary">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-secondary">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 text-secondary text-decoration-underline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-dark">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p id="profile-status" class="ms-3 text-success mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@if (session('status') === 'profile-updated')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const statusElement = document.getElementById('profile-status');
                if (statusElement) {
                    statusElement.style.transition = 'opacity 0.5s ease';
                    statusElement.style.opacity = '0';
                    setTimeout(() => statusElement.remove(), 500);
                }
            }, 2000);
        });
    </script>
@endif
