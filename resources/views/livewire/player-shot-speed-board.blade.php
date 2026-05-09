<div class="mx-auto flex w-full max-w-4xl flex-col gap-6">
    <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
        <h2 class="mb-4 text-lg font-semibold">Oyuncu Şut Hızını Ekle</h2>

        <form wire:submit="savePlayer" class="grid gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <label for="player-name" class="mb-1 block text-sm font-medium">Oyuncu Adı</label>
                <input id="player-name" type="text" wire:model.live="playerName"
                    class="w-full rounded-md border border-neutral-300 px-3 py-2 dark:border-neutral-600 dark:bg-neutral-900"
                    placeholder="Oyuncu adını girin">
                @error('playerName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="shot-speed" class="mb-1 block text-sm font-medium">Şut Hızı (km/h)</label>
                <input id="shot-speed" type="number" min="1" max="300" step="0.1"
                    wire:model.live="shotSpeed"
                    class="w-full rounded-md border border-neutral-300 px-3 py-2 dark:border-neutral-600 dark:bg-neutral-900"
                    placeholder="örnek: 122.4">
                @error('shotSpeed')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-3">
                <flux:button type="submit" variant="primary">
                    Kaydet
                </flux:button>
            </div>
        </form>
    </div>

    <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
        <h2 class="mb-4 text-lg font-semibold">En Hızlı Şutlar</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-neutral-200 dark:border-neutral-700">
                        <th class="py-2">#</th>
                        <th class="py-2">Oyuncu</th>
                        <th class="py-2">Şut Hızı (km/h)</th>
                        <th class="py-2 text-right">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($players as $player)
                        <tr wire:key="player-{{ $player->id }}"
                            class="border-b border-neutral-100 dark:border-neutral-800">
                            <td class="py-2">{{ $players->firstItem() + $loop->index }}</td>
                            @if ($editingPlayerId === $player->id)
                                <td class="py-2">
                                    <input type="text" wire:model.live="editPlayerName"
                                        class="w-full rounded-md border border-neutral-300 px-2 py-1 dark:border-neutral-600 dark:bg-neutral-900">
                                    @error('editPlayerName')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="py-2">
                                    <input type="number" min="1" max="300" step="0.1"
                                        wire:model.live="editShotSpeed"
                                        class="w-full rounded-md border  border-neutral-300 px-2 py-1 dark:border-neutral-600 dark:bg-neutral-900">
                                    @error('editShotSpeed')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-end gap-2">
                                        <flux:button size="sm" variant="primary"
                                            wire:click="updatePlayer({{ $player->id }})" aria-label="Kaydet">
                                            <flux:icon.check class="size-4" />
                                        </flux:button>
                                        <flux:button size="sm" variant="ghost" wire:click="cancelEditing"
                                            aria-label="Vazgeç">
                                            <flux:icon.x-mark class="size-4" />
                                        </flux:button>
                                    </div>
                                </td>
                            @else
                                <td class="py-2">{{ $player->name }}</td>
                                <td
                                    class="py-2 @if ((float) $player->shot_speed_kmh >= $averageSpeed) text-green-600 dark:text-green-400 @else text-blue-600 dark:text-blue-400 @endif">
                                    {{ number_format((float) $player->shot_speed_kmh, 1) }}</td>
                                <td class="py-2">
                                    <div class="flex justify-end gap-2">
                                        <flux:button size="sm" variant="ghost"
                                            wire:click="startEditing({{ $player->id }})" aria-label="Düzenle">
                                            <flux:icon.pencil-square class="size-4" />
                                        </flux:button>
                                        <a href="{{ route('shot-speed.report', $player) }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="inline-flex items-center justify-center rounded-md border border-neutral-300 bg-white px-2 py-1 text-sm text-neutral-700 transition hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200 dark:hover:bg-neutral-800"
                                            aria-label="Rapor">
                                            Rapor
                                        </a>
                                        <flux:button size="sm" variant="danger"
                                            wire:confirm="Kaydı silmek istediğinize emin misiniz?"
                                            wire:click="deletePlayer({{ $player->id }})" aria-label="Sil">
                                            <flux:icon.trash class="size-4" />
                                        </flux:button>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-neutral-500">Henüz oyuncu kaydı yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($averageSpeed > 0)
            <div class="mt-4 rounded-lg bg-neutral-50 p-4 dark:bg-neutral-800">
                <div class="text-center">
                    <div class="text-sm text-neutral-600 dark:text-neutral-400">Ortalama Şut Hızı</div>
                    <div class="text-2xl font-bold text-neutral-900 dark:text-neutral-100">
                        {{ number_format((float) $averageSpeed, 1) }} km/h</div>
                </div>
            </div>
        @endif

        <div class="mt-4">
            {{ $players->links() }}
        </div>
    </div>
</div>


<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('player-saved', ({
            id
        }) => {
            // Wait one tick for Livewire to re-render the DOM
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    const row = document.querySelector(`[wire\\:key="player-${id}"]`);
                    if (row) {
                        row.classList.remove('row-flash-in'); // reset if re-triggered
                        void row.offsetWidth; // force reflow
                        row.classList.add('row-flash-in');
                        row.addEventListener('animationend', () => {
                            row.classList.remove('row-flash-in');
                        }, {
                            once: true
                        });
                    }
                });
            });
        });
    });
</script>
