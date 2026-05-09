<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Görünüm ayarları')] class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Görünüm ayarları') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Görünüm')" :subheading="__('Hesap için görünüm ayarlarını güncelleyin')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Açık') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Koyu') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('Sistem') }}</flux:radio>
        </flux:radio.group>
    </x-pages::settings.layout>
</section>
