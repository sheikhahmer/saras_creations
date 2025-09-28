<?php

namespace App\Filament\Admin\Widgets;

use App\Models\ProductVariant;
use Filament\Widgets\Widget;

class LowStockAlert extends Widget
{
    protected string $view = 'filament.admin.widgets.low-stock-alert';

    protected int|string|array $columnSpan = 'full';

    public function getVariants()
    {
        return ProductVariant::where('quantity', '<=', 0)->get();
    }
}
