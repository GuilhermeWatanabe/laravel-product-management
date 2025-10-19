<section>
    <header>
        <h2 class="h5 text-dark">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-secondary">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
            @error('password', 'updatePassword')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-dark">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p id="password-status" class="ms-3 text-success mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@if (session('status') === 'password-updated')
    <script>
        // Simple script to make the "Saved." message disappear after 2 seconds.
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const statusElement = document.getElementById('password-status');
                if (statusElement) {
                    // Optional: add a fade-out effect
                    statusElement.style.transition = 'opacity 0.5s ease';
                    statusElement.style.opacity = '0';
                    setTimeout(() => statusElement.remove(), 500); // Remove from DOM after fade
                }
            }, 2000);
        });
    </script>
@endif
