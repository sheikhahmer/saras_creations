<?php

namespace App\Filament\Admin\Resources\Manufacturings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ManufacturingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('manufacturer')
                    ->required(),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('total_cost', $state * $get('cost_per_kg'))
                    ),

                TextInput::make('cost_per_kg')
                    ->required()
                    ->numeric()
                    ->default(100) // default per KG cost
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('total_cost', $state * $get('quantity'))
                    ),

                TextInput::make('total_cost')
                    ->numeric()
                    ->disabled() // read-only
                    ->dehydrated(false), // don't save directly, calculate in model

                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) =>
                    $set('due_amount', ($get('total_cost') ?? 0) - $state)
                    ),

                TextInput::make('due_amount')
                    ->numeric()
                    ->disabled() // read-only
                    ->dehydrated(false), // auto-calculated only

                DatePicker::make('manufactured_at')
                    ->required(),
            ]);
    }

}
