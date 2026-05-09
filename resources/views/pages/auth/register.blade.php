<x-layouts::auth :title="__('Kayıt ol')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Hesap oluştur')" :description="__('Hesap oluşturmak için aşağıya bilgilerinizi girin')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Ad soyad')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Ad soyad')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email adresi')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Parola')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Parola')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Şifreyi onayla')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Şifreyi onayla')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Hesap oluştur') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Zaten hesap var mı?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Giriş yap') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
