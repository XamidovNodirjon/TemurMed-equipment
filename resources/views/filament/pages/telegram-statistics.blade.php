@php
    $daily = $this->getDailyReport();
    $monthly = $this->getMonthlyReport();
    $monthOptions = $this->getMonthOptions();
    $num = fn ($value) => number_format($value, 0, '.', ' ');
@endphp

<x-filament-panels::page>
    <div class="grid gap-y-8">
        {{-- Kunlik hisobot --}}
        <x-filament::section
            id="daily-report"
            icon="heroicon-o-calendar-days"
            heading="Ежедневный отчёт"
            :description="'Количество нажатий по дням — ' . ($monthOptions[$this->month] ?? '')"
        >
            <x-slot name="headerEnd">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="month" aria-label="Месяц">
                        @foreach ($monthOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </x-slot>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(10rem, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                @foreach ([
                    ['Всего за месяц', $num($daily['totals']['total'])],
                    ['Уникальные', $num($daily['totals']['visitors'])],
                    ['В среднем в день', $daily['totals']['average']],
                    ['Лучший день', $daily['totals']['best'] ? $daily['totals']['best']['date'] . ' (' . $daily['totals']['best']['total'] . ')' : '—'],
                ] as [$label, $value])
                    <div class="rounded-xl bg-gray-50 px-4 py-3 ring-1 ring-gray-950/5 dark:bg-white/5 dark:ring-white/10">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
                        <p class="mt-1 text-lg font-semibold text-gray-950 dark:text-white">{{ $value }}</p>
                    </div>
                @endforeach
            </div>

            <div class="overflow-x-auto rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10" wire:loading.class="opacity-50">
                <x-filament-tables::table>
                    <x-slot name="header">
                        <x-filament-tables::header-cell>Дата</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Кнопка</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">QR-код</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Всего</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Уникальные</x-filament-tables::header-cell>
                    </x-slot>

                    @foreach ($daily['rows'] as $row)
                        <x-filament-tables::row :striped="$row['is_today']">
                            <x-filament-tables::cell>
                                <div class="flex items-center gap-x-2 px-3 py-3">
                                    <span class="text-sm font-medium text-gray-950 dark:text-white">{{ $row['date'] }}</span>
                                    <span @class(['text-xs', 'text-danger-600 dark:text-danger-400' => $row['is_weekend'], 'text-gray-500 dark:text-gray-400' => ! $row['is_weekend']])>{{ $row['weekday'] }}</span>
                                    @if ($row['is_today'])
                                        <x-filament::badge color="success" size="sm">Сегодня</x-filament::badge>
                                    @endif
                                </div>
                            </x-filament-tables::cell>
                            @foreach (['button', 'qr', 'total', 'visitors'] as $key)
                                <x-filament-tables::cell>
                                    <div @class([
                                        'px-3 py-3 text-end text-sm',
                                        'text-gray-400 dark:text-gray-500' => $row[$key] === 0,
                                        'font-semibold text-gray-950 dark:text-white' => $row[$key] > 0 && $key === 'total',
                                        'text-gray-700 dark:text-gray-200' => $row[$key] > 0 && $key !== 'total',
                                    ])>{{ $num($row[$key]) }}</div>
                                </x-filament-tables::cell>
                            @endforeach
                        </x-filament-tables::row>
                    @endforeach

                    <x-slot name="footer">
                        <x-filament-tables::cell>
                            <div class="px-3 py-3 text-sm font-semibold text-gray-950 dark:text-white">Итого</div>
                        </x-filament-tables::cell>
                        @foreach (['button', 'qr', 'total', 'visitors'] as $key)
                            <x-filament-tables::cell>
                                <div class="px-3 py-3 text-end text-sm font-semibold text-gray-950 dark:text-white">{{ $num($daily['totals'][$key]) }}</div>
                            </x-filament-tables::cell>
                        @endforeach
                    </x-slot>
                </x-filament-tables::table>
            </div>
        </x-filament::section>

        {{-- Oylik hisobot --}}
        <x-filament::section
            icon="heroicon-o-chart-bar"
            heading="Ежемесячный отчёт"
            :description="'Итоги по месяцам за ' . $monthly['year'] . ' год. Нажмите на месяц, чтобы открыть дневной отчёт.'"
        >
            <x-slot name="headerEnd">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="year" aria-label="Год">
                        @foreach ($this->getYearOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </x-slot>

            <div class="overflow-x-auto rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10" wire:loading.class="opacity-50">
                <x-filament-tables::table>
                    <x-slot name="header">
                        <x-filament-tables::header-cell>Месяц</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Кнопка</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">QR-код</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Всего</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">Уникальные</x-filament-tables::header-cell>
                        <x-filament-tables::header-cell alignment="end">В среднем / день</x-filament-tables::header-cell>
                    </x-slot>

                    @foreach ($monthly['rows'] as $row)
                        <x-filament-tables::row :striped="$row['key'] === $this->month">
                            <x-filament-tables::cell>
                                <button type="button"
                                        wire:click="showMonth('{{ $row['key'] }}')"
                                        x-on:click="document.getElementById('daily-report')?.scrollIntoView({ behavior: 'smooth' })"
                                        class="flex w-full items-center gap-x-2 px-3 py-3 text-start">
                                    <span class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-400">{{ $row['label'] }}</span>
                                    @if ($row['is_current'])
                                        <x-filament::badge color="success" size="sm">Текущий</x-filament::badge>
                                    @endif
                                </button>
                            </x-filament-tables::cell>
                            @foreach (['button', 'qr', 'total', 'visitors', 'average'] as $key)
                                <x-filament-tables::cell>
                                    <div @class([
                                        'px-3 py-3 text-end text-sm',
                                        'text-gray-400 dark:text-gray-500' => $row[$key] == 0,
                                        'font-semibold text-gray-950 dark:text-white' => $row[$key] > 0 && $key === 'total',
                                        'text-gray-700 dark:text-gray-200' => $row[$key] > 0 && $key !== 'total',
                                    ])>{{ $key === 'average' ? $row[$key] : $num($row[$key]) }}</div>
                                </x-filament-tables::cell>
                            @endforeach
                        </x-filament-tables::row>
                    @endforeach

                    <x-slot name="footer">
                        <x-filament-tables::cell>
                            <div class="px-3 py-3 text-sm font-semibold text-gray-950 dark:text-white">Итого за {{ $monthly['year'] }}</div>
                        </x-filament-tables::cell>
                        @foreach (['button', 'qr', 'total', 'visitors'] as $key)
                            <x-filament-tables::cell>
                                <div class="px-3 py-3 text-end text-sm font-semibold text-gray-950 dark:text-white">{{ $num($monthly['totals'][$key]) }}</div>
                            </x-filament-tables::cell>
                        @endforeach
                        <x-filament-tables::cell></x-filament-tables::cell>
                    </x-slot>
                </x-filament-tables::table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
