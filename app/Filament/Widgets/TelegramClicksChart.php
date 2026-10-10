<?php

namespace App\Filament\Widgets;

use App\Models\TelegramClick;
use Filament\Widgets\ChartWidget;

class TelegramClicksChart extends ChartWidget
{
    // Faqat "Telegram статистика" sahifasida ko'rinadi
    protected static bool $isDiscovered = false;

    protected static ?string $heading = 'Динамика переходов в Telegram';

    protected static ?string $maxHeight = '300px';

    protected static ?string $pollingInterval = '60s';

    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Последние 7 дней',
            '30' => 'Последние 30 дней',
            '90' => 'Последние 90 дней',
        ];
    }

    protected function getData(): array
    {
        $days = in_array($this->filter, ['7', '30', '90']) ? (int) $this->filter : 30;
        $end = TelegramClick::now();
        $start = $end->copy()->subDays($days - 1);

        try {
            $stats = TelegramClick::dailyStats($start->toDateString(), $end->toDateString());
        } catch (\Exception $e) {
            $stats = collect();
        }

        $labels = $button = $qr = [];
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $row = $stats[$date->toDateString()] ?? null;
            $labels[] = $date->format('d.m');
            $button[] = (int) ($row->button ?? 0);
            $qr[] = (int) ($row->qr ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Кнопка',
                    'data' => $button,
                    'backgroundColor' => '#2AABEE',
                    'borderColor' => '#2AABEE',
                    'borderRadius' => 4,
                ],
                [
                    'label' => 'QR-код',
                    'data' => $qr,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true],
            ],
            'scales' => [
                'x' => ['stacked' => true, 'grid' => ['display' => false]],
                'y' => ['stacked' => true, 'beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
