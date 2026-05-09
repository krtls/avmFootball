<x-layouts::auth :title="__('Parolamı sıfırla')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Parolamı sıfırla')" :description="__('Lütfen aşağıya yeni parolanızı girin')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:input
                name="email"
                value="{{ request('email') }}"
                :label="__('Email')"
                type="email"
                required
                autocomplete="email"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Parola')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Yeni Parola')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Parola onayı')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Parola onayı')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                    {{ __('Parolamı sıfırla') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
