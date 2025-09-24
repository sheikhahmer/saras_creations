<?php

namespace App\Filament\Admin\Resources\Purchases\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('vendor_id')
                ->label('Vendor')
                ->options(\App\Models\Vendor::pluck('name', 'id'))
                ->searchable()
                ->required(),


        TextInput::make('material_name')
                ->label('Material')
                ->required(),

            TextInput::make('quantity_kg')
                ->numeric()
                ->required()
                ->reactive(), // makes changes trigger updates

            TextInput::make('rate_per_kg')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                $set('total_amount', $get('quantity_kg') * $state)
                ),

            TextInput::make('total_amount')
                ->numeric()
                ->disabled()
                ->dehydrated(), // will still save in DB

            DatePicker::make('purchase_date')
                ->label('Purchase Date')
                ->required(),
        ]);
    }
}
