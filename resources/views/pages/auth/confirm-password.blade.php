<x-layouts::auth :title="__('Parolayı onayla')">
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Parolayı onayla')"
            :description="__('Bu, uygulamanın güvenli bir alanıdır. Lütfen devam etmeden önce parolanızı onaylayın.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('Parola')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Parola')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                {{ __('Parolayı onayla') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
