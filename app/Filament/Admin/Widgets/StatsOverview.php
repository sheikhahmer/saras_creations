<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Total Products')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Products', Product::count())
                ->description('Total Products')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Products', Product::count())
                ->description('Total Products')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

        ];
    }
}
