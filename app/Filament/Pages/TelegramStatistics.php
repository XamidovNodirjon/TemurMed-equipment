<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TelegramClicksChart;
use App\Filament\Widgets\TelegramStatsOverview;
use App\Models\TelegramClick;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;

class TelegramStatistics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationLabel = 'Telegram статистика';

    protected static ?string $title = 'Статистика Telegram-канала';

    protected static ?string $slug = 'telegram-statistics';

    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.telegram-statistics';

    public string $month = '';

    public int $year = 0;

    public function mount(): void
    {
        $now = TelegramClick::now();
        $this->month = $now->format('Y-m');
        $this->year = $now->year;
    }

    public function getSubheading(): ?string
    {
        return 'Переходы в канал ' . config('services.telegram.channel_url') . ' (часовой пояс: ' . TelegramClick::timezone() . ')';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TelegramStatsOverview::class,
            TelegramClicksChart::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 1;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportDaily')
                ->label('Скачать отчёт (CSV)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(fn () => $this->exportDailyCsv()),
        ];
    }

    /**
     * Tanlangan oy (Y-m) xavfsiz holatda.
     */
    protected function selectedMonth(): Carbon
    {
        $now = TelegramClick::now();

        try {
            $month = Carbon::createFromFormat('Y-m-d', $this->month . '-01', TelegramClick::timezone())->startOfDay();
        } catch (\Throwable $e) {
            $month = $now->copy()->startOfMonth();
        }

        return $month->greaterThan($now) ? $now->copy()->startOfMonth() : $month;
    }

    protected function firstClickDate(): Carbon
    {
        $now = TelegramClick::now();

        try {
            $first = TelegramClick::min('clicked_date');
        } catch (\Throwable $e) {
            $first = null;
        }

        return $first ? Carbon::parse($first, TelegramClick::timezone()) : $now->copy();
    }

    public function getMonthOptions(): array
    {
        $now = TelegramClick::now()->startOfMonth();
        // Kamida oxirgi 12 oy ko'rsatiladi
        $from = $this->firstClickDate()->startOfMonth()->min($now->copy()->subMonths(11));

        $options = [];
        for ($m = $now->copy(); $m->gte($from); $m->subMonthNoOverflow()) {
            $options[$m->format('Y-m')] = mb_convert_case($m->locale('ru')->isoFormat('MMMM YYYY'), MB_CASE_TITLE);
        }

        return $options;
    }

    public function getYearOptions(): array
    {
        $current = TelegramClick::now()->year;
        $from = min($this->firstClickDate()->year, $current);

        return array_combine(range($current, $from), range($current, $from));
    }

    /**
     * Tanlangan oy uchun kunlik hisobot (yangi kunlar yuqorida).
     */
    public function getDailyReport(): array
    {
        $month = $this->selectedMonth();
        $now = TelegramClick::now();
        $end = $month->isSameMonth($now) ? $now->copy()->startOfDay() : $month->copy()->endOfMonth()->startOfDay();

        try {
            $stats = TelegramClick::dailyStats($month->toDateString(), $end->toDateString());
            $uniqueTotal = TelegramClick::where('clicked_month', $month->format('Y-m'))->distinct()->count('ip_hash');
        } catch (\Throwable $e) {
            $stats = collect();
            $uniqueTotal = 0;
        }

        $rows = [];
        for ($day = $end->copy(); $day->gte($month); $day->subDay()) {
            $row = $stats[$day->toDateString()] ?? null;
            $rows[] = [
                'date' => $day->format('d.m.Y'),
                'weekday' => mb_convert_case($day->locale('ru')->isoFormat('dd'), MB_CASE_TITLE),
                'is_today' => $day->isSameDay($now),
                'is_weekend' => $day->isWeekend(),
                'button' => (int) ($row->button ?? 0),
                'qr' => (int) ($row->qr ?? 0),
                'total' => (int) ($row->total ?? 0),
                'visitors' => (int) ($row->visitors ?? 0),
            ];
        }

        $collection = collect($rows);
        $daysCount = max(count($rows), 1);

        return [
            'rows' => $rows,
            'totals' => [
                'button' => $collection->sum('button'),
                'qr' => $collection->sum('qr'),
                'total' => $collection->sum('total'),
                'visitors' => $uniqueTotal,
                'average' => round($collection->sum('total') / $daysCount, 1),
                'best' => $collection->sortByDesc('total')->first(fn ($r) => $r['total'] > 0),
            ],
        ];
    }

    /**
     * Tanlangan yil uchun oylik hisobot.
     */
    public function getMonthlyReport(): array
    {
        $now = TelegramClick::now();
        $year = $this->year >= 2000 && $this->year <= $now->year ? $this->year : $now->year;
        $lastMonth = $year === $now->year ? $now->month : 12;

        try {
            $stats = TelegramClick::monthlyStats($year);
            $uniqueTotal = TelegramClick::where('clicked_month', 'like', $year . '-%')->distinct()->count('ip_hash');
        } catch (\Throwable $e) {
            $stats = collect();
            $uniqueTotal = 0;
        }

        $rows = [];
        for ($m = $lastMonth; $m >= 1; $m--) {
            $date = Carbon::create($year, $m, 1, 0, 0, 0, TelegramClick::timezone());
            $row = $stats[$date->format('Y-m')] ?? null;
            $total = (int) ($row->total ?? 0);
            $days = $date->isSameMonth($now) ? $now->day : $date->daysInMonth;

            $rows[] = [
                'key' => $date->format('Y-m'),
                'label' => mb_convert_case($date->locale('ru')->isoFormat('MMMM'), MB_CASE_TITLE),
                'is_current' => $date->isSameMonth($now),
                'button' => (int) ($row->button ?? 0),
                'qr' => (int) ($row->qr ?? 0),
                'total' => $total,
                'visitors' => (int) ($row->visitors ?? 0),
                'average' => round($total / max($days, 1), 1),
            ];
        }

        $collection = collect($rows);

        return [
            'year' => $year,
            'rows' => $rows,
            'totals' => [
                'button' => $collection->sum('button'),
                'qr' => $collection->sum('qr'),
                'total' => $collection->sum('total'),
                'visitors' => $uniqueTotal,
            ],
        ];
    }

    /**
     * Oylik jadvaldagi oyni bosganda kunlik hisobotga o'tish.
     */
    public function showMonth(string $month): void
    {
        if (preg_match('/^\d{4}-\d{2}$/', $month)) {
            $this->month = $month;
        }
    }

    protected function exportDailyCsv()
    {
        $month = $this->selectedMonth();
        $report = $this->getDailyReport();
        $filename = 'telegram-report-' . $month->format('Y-m') . '.csv';

        return response()->streamDownload(function () use ($report) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // Excel uchun UTF-8 BOM
            fputcsv($out, ['Дата', 'День', 'Кнопка', 'QR-код', 'Всего', 'Уникальные'], ';');

            foreach (array_reverse($report['rows']) as $row) {
                fputcsv($out, [$row['date'], $row['weekday'], $row['button'], $row['qr'], $row['total'], $row['visitors']], ';');
            }

            $t = $report['totals'];
            fputcsv($out, ['Итого', '', $t['button'], $t['qr'], $t['total'], $t['visitors']], ';');
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
