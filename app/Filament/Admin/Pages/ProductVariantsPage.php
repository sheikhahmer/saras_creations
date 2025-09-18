<?php

namespace App\Filament\Admin\Pages;

use App\Models\Product;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;

class ProductVariantsPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected string $view = 'filament.admin.pages.product-variants-page';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Product Variants';
    protected static ?int $navigationSort = 5;
    public ?int $productId = null;

    protected function getFormSchema(): array
    {
        return [
            Select::make('productId')
                ->label('Select Product')
                ->options(Product::pluck('name', 'id')->toArray())
                ->reactive()
                ->searchable(),
        ];
    }

    protected function getTableQuery()
    {
        return Product::find($this->productId)?->variants()->getQuery()
            ?? Product::query()->whereNull('id'); // empty fallback
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('sku')->label('SKU'),
            TextColumn::make('size'),
            TextColumn::make('color'),
            TextColumn::make('quantity'),
            TextColumn::make('price'),
        ];
    }
}
