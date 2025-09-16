<?php

namespace App\Filament\Admin\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone_no')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->required(),
                TextInput::make('city')
                    ->required(),
            ]);
    }
}
