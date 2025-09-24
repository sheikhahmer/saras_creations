<?php

namespace App\Filament\Admin\Resources\Manufacturings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Purchase;

class ManufacturingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('purchase_id')
                ->label('Purchase')
                ->options(
                    \App\Models\Purchase::with('vendor')
                        ->get()
                        ->mapWithKeys(fn ($purchase) => [
                            $purchase->id => "{$purchase->material_name} ({$purchase->vendor?->name})"
                        ])
                )
                ->searchable()
                ->required(),


        TextInput::make('manufacturing_cost_per_kg')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $purchase = Purchase::find($get('purchase_id'));
                    if ($purchase) {
                        $totalManu = $purchase->quantity_kg * $state;
                        $set('total_manufacturing_cost', $totalManu);
                        $set('final_cost', $purchase->total_amount + $totalManu);

                        $wastage = $get('wastage_kg') ?? 0;
                        $set('net_stock_kg', $purchase->quantity_kg - $wastage);
                    }
                }),

            TextInput::make('total_manufacturing_cost')
                ->numeric()
                ->disabled()
                ->dehydrated(),

            TextInput::make('final_cost')
                ->numeric()
                ->disabled()
                ->dehydrated(),

            TextInput::make('wastage_kg')
                ->numeric()
                ->default(0)
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $purchase = Purchase::find($get('purchase_id'));
                    if ($purchase) {
                        $set('net_stock_kg', $purchase->quantity_kg - $state);
                    }
                }),

            TextInput::make('net_stock_kg')
                ->numeric()
                ->disabled()
                ->dehydrated(),
        ]);
    }
}
