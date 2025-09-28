<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', Customer::count())
                ->description('Total Customers')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),

            Stat::make('Total Orders', Order::count())
                ->description('Total Orders')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Products', Product::count())
                ->description('Total Products')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Categories', Category::count())
                ->description('Total Categories')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Vendors', Vendor::count())
                ->description('Total Vendors')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),


        ];
    }
}
