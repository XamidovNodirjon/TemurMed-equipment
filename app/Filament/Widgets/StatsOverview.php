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
        $applicationCount = 0;
        try {
            $applicationCount = Application::count();
        } catch (\Exception $e) {}

        $productCount = 0;
        try {
            $productCount = Product::count();
        } catch (\Exception $e) {}

        $newsCount = 0;
        try {
            $newsCount = News::count();
        } catch (\Exception $e) {}

        return [
            Stat::make('Заявки', $applicationCount)
                ->description('Всего заявок')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('primary'),
            
            Stat::make('Продукты', $productCount)
                ->description('Активные товары')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
            
            Stat::make('Новости', $newsCount)
                ->description('Опубликованные новости')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),
        ];
    }
}
