<x-layouts::app :title="__('Oyuncu Raporu')">
    <div class="mx-auto flex max-w-5xl flex-col gap-6 p-6">
        <div
            class="flex flex-col gap-4 rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-950">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-neutral-950 dark:text-white">{{ $player->name }} - Oyuncu
                        Raporu</h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Bu rapor, seçilen oyuncu için şut hızı
                        verilerini içerir.</p>
                </div>

                <button id="print-report-button" type="button" onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-900 shadow-sm transition hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:bg-neutral-800">
                    PDF Olarak Kaydet
                </button>
            </div>

            <div
                class="grid gap-6 rounded-xl border border-neutral-200 bg-neutral-50 p-6 dark:border-neutral-700 dark:bg-neutral-900">
                <div class="grid gap-2">
                    <span class="text-sm uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Oyuncu</span>
                    <h2 class="text-xl font-semibold text-neutral-950 dark:text-white">{{ $player->name }}</h2>
                </div>

                <div class="grid gap-2 sm:grid-cols-2">
                    <div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-neutral-950">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Şut Hızı</p>
                        <p class="mt-2 text-3xl font-semibold text-neutral-950 dark:text-white">
                            {{ number_format((float) $player->shot_speed_kmh, 1) }} km/h</p>
                    </div>
                    <div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-neutral-950">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">Ortalama Şut Hızı</p>
                        <p class="mt-2 text-3xl font-semibold text-neutral-950 dark:text-white">
                            {{ number_format((float) $averageSpeed, 1) }} km/h</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-white p-4 shadow-sm dark:bg-neutral-950">
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Rapor Detayları</p>
                    <ul class="mt-4 grid gap-3 text-sm text-neutral-700 dark:text-neutral-300">
                        <li><strong>Oyuncu ID:</strong> {{ $player->id }}</li>
                        <li><strong>Oluşturulma:</strong> {{ $player->created_at?->format('d.m.Y H:i') ?? __('N/A') }}
                        </li>
                        <li><strong>Güncelleme:</strong> {{ $player->updated_at?->format('d.m.Y H:i') ?? __('N/A') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background: #fff !important;
            }

            html,
            body {
                color: #000 !important;
            }

            flux-sidebar,
            flux-header,
            #print-report-button,
            .flux-sidebar,
            .flux-header {
                display: none !important;
            }

            .print\:no-show {
                display: none !important;
            }
        }
    </style>
</x-layouts::app>
