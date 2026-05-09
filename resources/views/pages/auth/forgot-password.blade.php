<x-layouts::auth :title="__('Parolamı unuttum')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Parolamı unuttum')" :description="__('Email adresinizi girin ve şifre sıfırlama bağlantısı alın')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email adresi')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('E-posta şifre sıfırlama bağlantısı gönder') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Veya, geri dön') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Giriş yap') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
