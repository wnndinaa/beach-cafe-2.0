<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
        </p>
    </header>

    <!-- Delete Account Form -->
    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
        @csrf
        @method('delete')

        <!-- Password Input -->
        <div class="mb-4">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input 
                id="password" 
                name="password" 
                type="password" 
                class="form-control" 
                placeholder="{{ __('Enter your password to confirm') }}" 
                required
            >
            @if ($errors->userDeletion->get('password'))
                <div class="text-danger mt-2">
                    {{ $errors->userDeletion->get('password')[0] }}
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content">
            <button type="submit" class="btn btn-danger">
                {{ __('Delete Account') }}
            </button>
        </div>
    </form>
</section>
