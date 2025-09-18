<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ProductVariantsTable extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    public $variants;

    public function mount($variants)
    {
        $this->variants = $variants;
    }

public $variantsQuery;

protected function getTableQuery()
{
    return $this->variantsQuery;
}   

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('sku')->label('SKU'),
            TextColumn::make('name')->label('Name'),
            TextColumn::make('size')->label('Size'),
            TextColumn::make('color')->label('Color'),
            TextColumn::make('quantity')->label('Quantity')->numeric(),
            TextColumn::make('price')->label('Price')->money('INR'),
        ];
    }

    public function render()
    {
        return view('livewire.product-variants-table');
    }
}

