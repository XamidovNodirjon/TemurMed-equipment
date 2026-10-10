<?php

namespace App\Filament\Widgets;

use App\Models\TelegramClick;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TelegramStatsOverview extends BaseWidget
{
    // Faqat "Telegram статистика" sahifasida ko'rinadi
    protected static bool $isDiscovered = false;

    protected static ?string $pollingInterval = '30s';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $now = TelegramClick::now();
        $today = $now->toDateString();
        $yesterday = $now->copy()->subDay()->toDateString();

        try {
            $last7 = TelegramClick::dailyStats($now->copy()->subDays(6)->toDateString(), $today);
            $todayCount = (int) ($last7[$today]->total ?? 0);
            $yesterdayCount = (int) ($last7[$yesterday]->total ?? 0);
            $todayVisitors = (int) ($last7[$today]->visitors ?? 0);

            $monthCount = TelegramClick::where('clicked_month', $now->format('Y-m'))->count();
            // O'tgan oyning xuddi shu davri bilan solishtirish
            $prevMonthStart = $now->copy()->startOfMonth()->subMonthNoOverflow();
            $prevMonthSamePeriod = TelegramClick::whereBetween('clicked_date', [
                $prevMonthStart->toDateString(),
                $prevMonthStart->copy()->day(min($now->day, $prevMonthStart->daysInMonth))->toDateString(),
            ])->count();

            $total = TelegramClick::count();
            $totalQr = TelegramClick::where('source', TelegramClick::SOURCE_QR)->count();
        } catch (\Exception $e) {
            $last7 = collect();
            $todayCount = $yesterdayCount = $todayVisitors = $monthCount = $prevMonthSamePeriod = $total = $totalQr = 0;
        }

        $sparkline = [];
        for ($i = 6; $i >= 0; $i--) {
            $sparkline[] = (int) ($last7[$now->copy()->subDays($i)->toDateString()]->total ?? 0);
        }

        return [
            $this->compare(
                Stat::make('Сегодня', $todayCount)->chart($sparkline),
                $todayCount,
                $yesterdayCount,
                'к вчерашнему дню'
            )->extraAttributes(['title' => 'Уникальных посетителей: ' . $todayVisitors]),

            Stat::make('Вчера', $yesterdayCount)
                ->description($now->copy()->subDay()->format('d.m.Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            $this->compare(
                Stat::make('Этот месяц', $monthCount),
                $monthCount,
                $prevMonthSamePeriod,
                'к прошлому месяцу'
            ),

            Stat::make('Всего переходов', $total)
                ->description('Кнопка: ' . ($total - $totalQr) . ' · QR: ' . $totalQr)
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('info'),
        ];
    }

    protected function compare(Stat $stat, int $current, int $previous, string $suffix): Stat
    {
        if ($previous === 0) {
            return $stat
                ->description($current > 0 ? 'Новые переходы' : 'Пока нет переходов')
                ->descriptionIcon($current > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-minus')
                ->color($current > 0 ? 'success' : 'gray');
        }

        $diff = (int) round(($current - $previous) / $previous * 100);

        return $stat
            ->description(($diff > 0 ? '+' : '') . $diff . '% ' . $suffix)
            ->descriptionIcon($diff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($diff >= 0 ? 'success' : 'danger');
    }
}
