<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Application;
use App\Models\Product;
use App\Models\News;
use Illuminate\Support\Facades\App;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Заявки', Application::count())
                ->description('Всего заявок')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('primary'),
            
            Stat::make('Продукты', Product::count())
                ->description('Активные товары')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
            
            Stat::make('Новости', News::count())
                ->description('Опубликованные новости')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),
        ];
    }
}
