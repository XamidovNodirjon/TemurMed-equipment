<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicationsChart extends ChartWidget
{
    protected static ?string $heading = 'Статистика заявок (за последние 30 дней)';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Application::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fill in missing days
        $chartData = [];
        $labels = [];
        $startDate = now()->subDays(29);
        
        for ($i = 0; $i < 30; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $startDate->copy()->addDays($i)->format('d.m');
            $count = $data->firstWhere('date', $date)?->count ?? 0;
            $chartData[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Заявки',
                    'data' => $chartData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
